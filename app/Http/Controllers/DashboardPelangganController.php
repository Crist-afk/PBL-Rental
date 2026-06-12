<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Kostum;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardPelangganController extends Controller
{
    /**
     * Menampilkan Dashboard Pelanggan
     */
    public function index()
    {
        $userId = Auth::id();

        // Stats
        $stats = [
            'active_rentals' => Transaksi::where('user_id', $userId)->where('status', 'Disewa')->count(),
            'total_rentals'  => Transaksi::where('user_id', $userId)->count(),
        ];

        // Active Rentals (Kostum Sedang Disewa & Menunggu Pembayaran & Batal)
        $current_rentals = Transaksi::with(['detailTransaksi.kostum'])
            ->where('user_id', $userId)
            ->whereIn('status', ['Menunggu Pembayaran', 'Disewa', 'Batal'])
            ->get()
            ->map(function ($t) {
                $firstDetail = $t->detailTransaksi->first();
                $kostum = $firstDetail ? $firstDetail->kostum : null;
                $size = $firstDetail?->ukuran ?? 'N/A';

                // Calculate running fine if late
                $denda = 0;
                $daysLate = 0;
                if (in_array($t->status, ['Disewa', 'Menunggu Pembayaran']) && \Carbon\Carbon::now()->startOfDay()->greaterThan(\Carbon\Carbon::parse($t->tanggal_selesai)->startOfDay())) {
                    $daysLate = \Carbon\Carbon::parse($t->tanggal_selesai)->startOfDay()->diffInDays(\Carbon\Carbon::now()->startOfDay());
                    $denda = $daysLate * 50000;
                }

                return [
                    'id'          => $t->id,
                    'title'       => $kostum ? $kostum->nama_kostum : 'Transaksi #' . $t->id,
                    'size'        => $size,
                    'return_date' => \Carbon\Carbon::parse($t->tanggal_selesai)->format('d F Y'),
                    'price'       => $t->total_biaya,
                    'image'       => $kostum ? $kostum->gambar_url : null,
                    'status'      => $t->status_label,
                    'raw_status'  => $t->status,
                    'status_color'=> $t->status_color,
                    'catatan_admin'=> $t->catatan_admin,
                    'denda'       => $denda,
                    'days_late'   => $daysLate,
                    'payment_deadline' => \Carbon\Carbon::parse($t->created_at)->addDays(2)->format('d M Y, H:i'),
                ];
            });

        // Recent History – tampilkan semua status, limit 5
        $recent_history = Transaksi::with(['detailTransaksi.kostum'])
            ->where('user_id', $userId)
            ->latest()
            ->limit(5)
            ->get();

        // Recommendations (Static for now, but can be improved)
        $recommendations = \App\Models\Kostum::inRandomOrder()->limit(5)->get()->map(function($k) {
            return [
                'title'    => $k->nama_kostum,
                'category' => $k->kategori->nama_kategori ?? 'Umum',
                'color'    => 'bg-milk-tea',
                'image'    => $k->gambar_url
            ];
        });

        return view('pages.DashPelanggan', compact(
            'stats', 
            'current_rentals', 
            'recent_history', 
            'recommendations'
        ));
    }

    /**
     * Menampilkan Halaman Booking
     */
    public function booking(Request $request)
    {
        $kostums = Kostum::all();
        
        return view('pages.Booking', [
            'kostums' => $kostums,
            'kostum_id' => $request->query('kostum_id'),
            'selected_size' => $request->query('size'),
            'tanggal_sewa' => $request->query('tanggal_sewa'),
            'tanggal_kembali' => $request->query('tanggal_kembali'),
        ]);
    }

    /**
     * Menangani Pengiriman Form Booking
     */
    public function storeBooking(Request $request)
    {
        $request->validate([
            'kostum_id'       => 'required|exists:kostum,id',
            'size'            => 'required',
            'tanggal_sewa'    => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_sewa',
        ]);

        $kostum = Kostum::findOrFail($request->kostum_id);

        // Cek stok per ukuran
        $stokPerUkuran = $kostum->stok_per_ukuran ?? [];
        $size = $request->size;

        if (is_array($stokPerUkuran) && isset($stokPerUkuran[$size])) {
            if ($stokPerUkuran[$size] <= 0) {
                return back()->with('error', 'Costume size ' . $size . ' is out of stock.')->withInput();
            }
        } else {
            // Fallback ke stok umum jika stok_per_ukuran tidak ada/tidak sesuai
            if ($kostum->stok <= 0) {
                return back()->with('error', 'Costume is out of stock.')->withInput();
            }
        }

        $isBooked = DetailTransaksi::where('kostum_id', $request->kostum_id)
            ->where('ukuran', $size)
            ->whereHas('transaksi', function ($query) use ($request) {
                $query->whereIn('status', ['Menunggu Pembayaran', 'Disewa'])
                    ->where('tanggal_mulai', '<=', $request->tanggal_kembali)
                    ->where('tanggal_selesai', '>=', $request->tanggal_sewa);
            })
            ->exists();

        if ($isBooked) {
            return back()->with('error', 'Costume is already booked for those dates.')->withInput();
        }

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            $start = Carbon::parse($request->tanggal_sewa);
            $end   = Carbon::parse($request->tanggal_kembali);
            $days  = max(1, $start->diffInDays($end));

            $total_biaya = $kostum->harga_sewa * $days;

            // Buat Transaksi Utama
            $size = $request->size;
            $transaksi = Transaksi::create([
                'user_id'         => Auth::id(),
                'tanggal_mulai'   => $request->tanggal_sewa,
                'tanggal_selesai' => $request->tanggal_kembali,
                'total_biaya'     => $total_biaya,
                'status'          => 'Menunggu Pembayaran',
                'catatan'         => $request->catatan,
            ]);

            // Buat Detail Transaksi
            DetailTransaksi::create([
                'transaksi_id'              => $transaksi->id,
                'kostum_id'                 => $request->kostum_id,
                'ukuran'                    => $size,
                'harga_sewa_saat_transaksi' => $total_biaya
            ]);

            // ===== DECREASE COSTUME STOCK =====
            if ($size) {
                $stokPerUkuran = $kostum->stok_per_ukuran;
                if (is_array($stokPerUkuran) && isset($stokPerUkuran[$size])) {
                    $stokPerUkuran[$size] -= 1;
                    $kostum->stok_per_ukuran = $stokPerUkuran;
                }
            }
            $kostum->stok -= 1;
            $kostum->save();
            // ===============================

            \Illuminate\Support\Facades\DB::commit();

            return redirect()->route('dashboard.pelanggan')->with('success', 'Booking created successfully! Please wait for payment confirmation.');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->with('error', 'Failed to process booking: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan Halaman Riwayat
     */
    public function riwayat()
    {
        $historyItems = Transaksi::with(['detailTransaksi.kostum', 'pengembalian'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.Riwayat', compact('historyItems'));
    }

    /**
     * Menampilkan Halaman Faktur
     */
    public function faktur($id)
    {
        $transaksi = Transaksi::with(['detailTransaksi.kostum', 'user', 'pengembalian'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('pages.Faktur', compact('transaksi'));
    }

    /**
     * Menangani Upload Bukti Pembayaran
     */
    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $transaksi = Transaksi::where('user_id', Auth::id())
            ->where('status', 'Menunggu Pembayaran')
            ->findOrFail($id);

        if ($request->hasFile('bukti_pembayaran')) {
            // Delete old file if exists
            if ($transaksi->bukti_pembayaran && \Illuminate\Support\Facades\Storage::disk('public')->exists($transaksi->bukti_pembayaran)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($transaksi->bukti_pembayaran);
            }

            $path = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
            $transaksi->bukti_pembayaran = $path;
            $transaksi->save();

            return back()->with('success', 'Payment proof uploaded successfully. Waiting for admin confirmation.');
        }

        return back()->with('error', 'Failed to upload payment proof.');
    }
}
