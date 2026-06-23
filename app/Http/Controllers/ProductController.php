<?php

namespace App\Http\Controllers;

use App\Models\Kostum;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Menampilkan halaman katalog produk.
     * Mengambil data langsung dari database melalui Eloquent Model.
     */
    public function index(Request $request)
    {
        $query = Kostum::with('kategori');

        // Filter by Search Keyword
        if ($request->filled('search')) {
            $query->where('nama_kostum', 'like', '%' . $request->search . '%');
        }

        // Filter by Category
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        // Sort by Price
        if ($request->filled('sort')) {
            if ($request->sort == 'lowest') {
                $query->orderBy('harga_sewa', 'asc');
            } elseif ($request->sort == 'highest') {
                $query->orderBy('harga_sewa', 'desc');
            }
        } else {
            // Default sort: newest first
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = \App\Models\Kategori::orderBy('nama_kategori', 'asc')->get();

        return view('pages.product', compact('products', 'categories'));
    }

    /**
     * Menampilkan halaman detail satu kostum.
     * Menggunakan findOrFail() agar otomatis melempar 404 jika ID tidak ditemukan.
     */
    public function show($id)
    {
        // Eager-load relasi 'kategori' untuk menampilkan nama kategori di detail page
        $kostum = Kostum::with('kategori')->findOrFail($id);

        return view('pages.product-detail', compact('kostum'));
    }

    /**
     * Mengecek ketersediaan stok aktual berdasarkan tanggal dan ukuran
     */
    public function checkAvailability(Request $request)
    {
        $kostumId = $request->get('kostum_id');
        $size = $request->get('size');
        $start = $request->get('start');
        $end = $request->get('end');

        if (!$kostumId || !$size) {
            return response()->json(['error' => 'Missing parameters'], 400);
        }

        $kostum = Kostum::find($kostumId);
        if (!$kostum) {
            return response()->json(['error' => 'Costume not found'], 404);
        }

        // Get permanent stock for the size
        $stokPerUkuran = $kostum->stok_per_ukuran ?? [];
        $stokPermanen = 0;
        
        if (is_array($stokPerUkuran) && isset($stokPerUkuran[$size])) {
            $stokPermanen = $stokPerUkuran[$size];
        } else {
            $stokPermanen = $kostum->stok;
        }

        // Calculate booked count only if dates are provided
        $bookedCount = 0;
        if ($start && $end) {
            $bookedCount = \App\Models\DetailTransaksi::where('kostum_id', $kostumId)
                ->where('ukuran', $size)
                ->whereHas('transaksi', function ($query) use ($start, $end) {
                    $query->whereIn('status', [
                            'Menunggu Pembayaran',
                            'Menunggu Verifikasi',
                            'Sudah Dibayar',
                            'Disewa',
                        ])
                        ->where('tanggal_mulai', '<=', $end)
                        ->where('tanggal_selesai', '>=', $start);
                })
                ->count();
        }

        $stokAktual = max(0, $stokPermanen - $bookedCount);

        return response()->json([
            'stok_permanen' => $stokPermanen,
            'booked_count' => $bookedCount,
            'stok_aktual' => $stokAktual
        ]);
    }
}