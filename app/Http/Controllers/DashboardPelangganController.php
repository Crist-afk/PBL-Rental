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

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            $kostum = Kostum::findOrFail($request->kostum_id);
            
            $start = Carbon::parse($request->tanggal_sewa);
            $end   = Carbon::parse($request->tanggal_kembali);
            $days  = max(1, $start->diffInDays($end));
            
            $total_biaya = $kostum->harga_sewa * $days;

            // Buat Transaksi Utama
            $transaksi = Transaksi::create([
                'user_id'         => Auth::id(),
                'tanggal_mulai'   => $request->tanggal_sewa,
                'tanggal_selesai' => $request->tanggal_kembali,
                'total_biaya'     => $total_biaya,
                'total_denda'     => 0,
                'status'          => 'Disewa'
            ]);

            // Buat Detail Transaksi
            DetailTransaksi::create([
                'transaksi_id'              => $transaksi->id,
                'kostum_id'                 => $request->kostum_id,
                'harga_sewa_saat_transaksi' => $total_biaya
            ]);

            // Kurangi Stok Kostum
            $kostum->decrement('stok');

            \Illuminate\Support\Facades\DB::commit();
            
            return redirect()->route('dashboard.pelanggan')->with('success', 'Pemesanan berhasil! Kostum Anda kini aktif di daftar persewaan.');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->with('error', 'Gagal memproses pemesanan: ' . $e->getMessage())->withInput();
        }
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