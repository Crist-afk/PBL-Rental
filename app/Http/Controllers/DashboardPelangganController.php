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
            'active_rentals' => Transaksi::where('user_id', $userId)
                                 ->whereIn('status', ['Menunggu Pembayaran', 'Menunggu Verifikasi', 'Ditolak', 'Sudah Dibayar', 'Disewa'])
                                 ->count(),
            'total_rentals'  => Transaksi::where('user_id', $userId)->count(),
        ];

        // Active Rentals — semua status yang masih aktif (bukan Selesai/Batal)
        $current_rentals = Transaksi::with(['detailTransaksi.kostum'])
            ->where('user_id', $userId)
            ->whereIn('status', ['Menunggu Pembayaran', 'Menunggu Verifikasi', 'Ditolak', 'Sudah Dibayar', 'Disewa'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($t) {
                $firstDetail = $t->detailTransaksi->first();
                $kostum = $firstDetail ? $firstDetail->kostum : null;
                $size = $firstDetail?->ukuran ?? 'N/A';

                // Hitung denda otomatis — hanya untuk status Disewa yang sudah lewat tanggal
                $denda = 0;
                $daysLate = 0;
                if ($t->status === 'Disewa') {
                    $today      = \Carbon\Carbon::now()->startOfDay();
                    $tglSelesai = \Carbon\Carbon::parse($t->tanggal_selesai)->startOfDay();
                    if ($today->greaterThan($tglSelesai)) {
                        $daysLate = $tglSelesai->diffInDays($today);
                        $denda    = $daysLate * 50000;
                    }
                }

                // Deadline upload pembayaran (12 jam sejak booking)
                $paymentDeadline = \Carbon\Carbon::parse($t->created_at)->addHours(12);
                $deadlinePassed  = $paymentDeadline->isPast();

                return [
                    'id'                 => $t->id,
                    'title'              => $kostum ? $kostum->nama_kostum : 'Transaksi #' . $t->id,
                    'size'               => $size,
                    'start_date'         => \Carbon\Carbon::parse($t->tanggal_mulai)->format('d F Y'),
                    'return_date'        => \Carbon\Carbon::parse($t->tanggal_selesai)->format('d F Y'),
                    'price'              => $t->total_biaya,
                    'image'              => $kostum ? $kostum->gambar_url : null,
                    'status'             => $t->status_label,
                    'raw_status'         => $t->status,
                    'status_color'       => $t->status_color,
                    'catatan_admin'      => $t->catatan_admin,
                    'denda'              => $denda,
                    'days_late'          => $daysLate,
                    'payment_deadline'   => $paymentDeadline->format('d M Y, H:i'),
                    'deadline_passed'    => $deadlinePassed,
                    'has_payment_proof'  => !empty($t->bukti_pembayaran),
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
        if (!$request->has(['kostum_id', 'size', 'tanggal_sewa', 'tanggal_kembali'])) {
            return redirect()->route('products.index')->with('error', 'Please select a costume first from the catalog.');
        }

        $kostums = Kostum::where('id', $request->query('kostum_id'))->get();
        
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
     *
     * PR-2: Availability dihitung dinamis dari calendar overlap — tidak membaca stok_aktual database.
     * PR-3: Pessimistic lock (lockForUpdate) digunakan di dalam transaksi untuk mencegah double booking.
     */
    public function storeBooking(Request $request)
    {
        $request->validate([
            'kostum_id'       => 'required|exists:kostum,id',
            'size'            => 'required',
            'tanggal_sewa'    => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_sewa',
        ]);

        $size           = $request->size;
        $tanggalSewa    = $request->tanggal_sewa;
        $tanggalKembali = $request->tanggal_kembali;

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            // ── PR-3: Pessimistic Lock ──────────────────────────────────────────
            // Kunci baris kostum ini agar tidak ada request lain yang bisa membaca
            // nilai yang sama secara bersamaan hingga transaksi ini selesai.
            $kostum = Kostum::lockForUpdate()->findOrFail($request->kostum_id);

            // ── PR-2: Calendar Availability Check ─────────────────────────────
            // Hitung ketersediaan dinamis berdasarkan overlap booking aktif.
            // Tidak membaca stok_aktual atau stok_aktual_per_ukuran dari database.
            $availability = $kostum->getStokAktualBySize($size, $tanggalSewa, $tanggalKembali);

            if ($availability <= 0) {
                \Illuminate\Support\Facades\DB::rollBack();
                return back()
                    ->with('error', 'Costume size ' . $size . ' is not available for the selected dates.')
                    ->withInput();
            }

            // ── Hitung Total Biaya ─────────────────────────────────────────────
            $start       = Carbon::parse($tanggalSewa);
            $end         = Carbon::parse($tanggalKembali);
            $days        = max(1, $start->diffInDays($end));
            $total_biaya = $kostum->harga_sewa * $days;

            // ── Buat Transaksi Utama ───────────────────────────────────────────
            $transaksi = Transaksi::create([
                'user_id'         => Auth::id(),
                'tanggal_mulai'   => $tanggalSewa,
                'tanggal_selesai' => $tanggalKembali,
                'total_biaya'     => $total_biaya,
                'status'          => 'Menunggu Pembayaran',
                'catatan'         => $request->catatan,
            ]);

            // ── Buat Detail Transaksi ──────────────────────────────────────────
            DetailTransaksi::create([
                'transaksi_id'              => $transaksi->id,
                'kostum_id'                 => $kostum->id,
                'ukuran'                    => $size,
                'harga_sewa_saat_transaksi' => $total_biaya,
            ]);

            // ── TIDAK ADA decrement stok ───────────────────────────────────────
            // Slot kalender otomatis terkunci karena transaksi berstatus
            // 'Menunggu Pembayaran' sudah ada dengan tanggal yang overlap.

            \Illuminate\Support\Facades\DB::commit();

            return redirect()->route('riwayat.index')->with([
                'success'           => 'Booking created successfully! Please upload your payment proof.',
                'open_upload_modal' => $transaksi->id,
            ]);

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

        if ($transaksi->status === 'Batal' && str_contains($transaksi->catatan_admin ?? '', 'Auto-canceled')) {
            return redirect()->route('riwayat.index')->with('error', 'Invoice not available for auto-canceled transactions.');
        }

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

        // Izinkan upload untuk status Menunggu Pembayaran DAN Ditolak (re-upload setelah penolakan)
        $transaksi = Transaksi::where('user_id', Auth::id())
            ->whereIn('status', ['Menunggu Pembayaran', 'Ditolak'])
            ->findOrFail($id);

        if ($request->hasFile('bukti_pembayaran')) {
            // Hapus file lama jika ada
            if ($transaksi->bukti_pembayaran &&
                \Illuminate\Support\Facades\Storage::disk('public')->exists($transaksi->bukti_pembayaran)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($transaksi->bukti_pembayaran);
            }

            $path = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

            // Upload bukti → otomatis ubah status ke Menunggu Verifikasi
            // catatan_admin dikosongkan karena ini adalah upload baru
            $transaksi->update([
                'bukti_pembayaran' => $path,
                'status'           => 'Menunggu Verifikasi',
                'catatan_admin'    => null,
            ]);

            return back()->with('success', 'Payment proof uploaded successfully! Awaiting admin verification.');
        }

        return back()->with('error', 'Failed to upload payment proof.');
    }

    /**
     * Menampilkan Halaman Denda (Penalty)
     */
    public function penalty()
    {
        $userId = Auth::id();

        // Denda hanya berlaku untuk kostum yang sudah benar-benar diambil (status Disewa)
        $late_rentals = Transaksi::with(['detailTransaksi.kostum'])
            ->where('user_id', $userId)
            ->where('status', 'Disewa') // Hanya yang sudah diambil
            ->get()
            ->filter(function ($t) {
                return \Carbon\Carbon::now()->startOfDay()->greaterThan(
                    \Carbon\Carbon::parse($t->tanggal_selesai)->startOfDay()
                );
            })
            ->map(function ($t) {
                $firstDetail = $t->detailTransaksi->first();
                $kostum = $firstDetail ? $firstDetail->kostum : null;
                $size = $firstDetail?->ukuran ?? 'N/A';

                $daysLate = \Carbon\Carbon::parse($t->tanggal_selesai)->startOfDay()
                    ->diffInDays(\Carbon\Carbon::now()->startOfDay());
                $denda = $daysLate * 50000;

                return [
                    'id'          => $t->id,
                    'title'       => $kostum ? $kostum->nama_kostum : 'Transaksi #' . $t->id,
                    'size'        => $size,
                    'return_date' => \Carbon\Carbon::parse($t->tanggal_selesai)->format('d F Y'),
                    'image'       => $kostum ? $kostum->gambar_url : null,
                    'denda'       => $denda,
                    'days_late'   => $daysLate,
                ];
            })
            ->values();

        return view('pages.Penalty', compact('late_rentals'));
    }
}
