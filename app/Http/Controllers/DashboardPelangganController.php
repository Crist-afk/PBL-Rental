<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

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

        // Active Rentals (Kostum Sedang Disewa)
        $current_rentals = Transaksi::with(['detailTransaksi.kostum'])
            ->where('user_id', $userId)
            ->where('status', 'Disewa')
            ->get()
            ->map(function ($t) {
                $firstDetail = $t->detailTransaksi->first();
                $kostum = $firstDetail ? $firstDetail->kostum : null;
                return [
                    'id'          => $t->id,
                    'title'       => $kostum ? $kostum->nama_kostum : 'Transaksi #' . $t->id,
                    'size'        => $kostum ? $kostum->ukuran : 'N/A', // Assuming first size or simple size
                    'return_date' => \Carbon\Carbon::parse($t->tanggal_selesai)->format('d F Y'),
                    'price'       => $t->total_biaya,
                    'image'       => $kostum ? $kostum->gambar_url : null
                ];
            });

        // Recent History
        $recent_history = Transaksi::where('user_id', $userId)
            ->whereIn('status', ['Selesai', 'Batal'])
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get()
            ->map(function ($t) {
                return [
                    'title'  => $t->detailTransaksi->first()?->kostum->nama_kostum ?? 'Transaksi #' . $t->id,
                    'date'   => \Carbon\Carbon::parse($t->tanggal_mulai)->format('j M Y'),
                    'price'  => $t->total_biaya,
                    'status' => $t->status
                ];
            });

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
        return view('pages.Booking', [
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
        // Simulasi penyimpanan data
        // $request->validate([...]);
        
        return redirect()->route('booking.index')->with('success', 'Reservasi berhasil!');
    }

    /**
     * Menampilkan Halaman Riwayat
     */
    public function riwayat()
    {
        $historyItems = Transaksi::with(['detailTransaksi.kostum'])
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
        $transaksi = Transaksi::with(['detailTransaksi.kostum', 'user'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('pages.Faktur', compact('transaksi'));
    }
}