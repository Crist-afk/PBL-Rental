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
        $query = Kostum::with(['kategori', 'units']);

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
        // Eager-load kategori and kostum_unit rows for this costume
        $kostum = Kostum::with(['kategori', 'units'])->findOrFail($id);

        // Build stokAktualPerUkuran from kostum_unit rows
        // (calendar-based: counts active bookings for today)
        $stokAktualPerUkuran = [];
        foreach ($kostum->units as $unit) {
            $stokAktualPerUkuran[$unit->ukuran] = $kostum->getStokAktualBySize($unit->ukuran);
        }

        // Fallback: if no units configured, build from ukuran string
        if (empty($stokAktualPerUkuran) && $kostum->ukuran) {
            $sizes = array_map('trim', explode(',', $kostum->ukuran));
            foreach ($sizes as $size) {
                $stokAktualPerUkuran[$size] = 0;
            }
        }

        // Total available stock across all sizes
        $stokAktualTotal = $kostum->getStokAktualTotal();

        return view('pages.product-detail', compact('kostum', 'stokAktualPerUkuran', 'stokAktualTotal'));
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

        $stokAktual = $kostum->getStokAktualBySize($size, $start, $end);

        return response()->json([
            'stok_aktual' => $stokAktual
        ]);
    }
}