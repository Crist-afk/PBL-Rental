<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kostum;
use App\Models\Kategori;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Pengembalian;
use App\Models\User;
use App\Models\ForumPost;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AdminController extends Controller
{
    // =====================================================================
    // DASHBOARD
    // =====================================================================
    public function dashboard()
    {
        $stats = [
            'total_kostum'         => Kostum::count(),
            'total_pelanggan'      => User::where('role', 'pelanggan')->count(),
            'sewa_aktif'           => Transaksi::where('status', 'Disewa')->count(),
            'menunggu_verifikasi'  => Transaksi::where('status', 'Menunggu Verifikasi')->count(),
            'sudah_dibayar'        => Transaksi::where('status', 'Sudah Dibayar')->count(),
            'menunggu_bayar'       => Transaksi::where('status', 'Menunggu Pembayaran')->count(),
            'total_pendapatan'     => Transaksi::whereIn('status', ['Sudah Dibayar', 'Disewa', 'Selesai'])->sum('total_biaya'),
        ];

        // ── Statistik Cepat ─────────────────────────────────────────────
        $totalSelesai = Transaksi::where('status', 'Selesai')->count();

        $tepat_waktu = Pengembalian::whereHas('transaksi', function ($q) {
            $q->where('status', 'Selesai')
              ->whereColumn('pengembalian.tanggal_kembali_aktual', '<=', 'transaksi.tanggal_selesai');
        })->count();

        $persen_tepat_waktu = $totalSelesai > 0
            ? round(($tepat_waktu / $totalSelesai) * 100, 1)
            : 0;

        $terlambat_count = Pengembalian::whereHas('transaksi', function ($q) {
            $q->where('status', 'Selesai')
              ->whereColumn('pengembalian.tanggal_kembali_aktual', '>', 'transaksi.tanggal_selesai');
        })->count();

        $tingkat_keterlambatan = $totalSelesai > 0
            ? round(($terlambat_count / $totalSelesai) * 100, 1)
            : 0;

        $total_akun = User::count();

        // ── Chart: Kostum dipesan per bulan ─────────────────────────────
        $kostumPerBulan = [];
        $bulanLabels    = [];
        for ($i = 11; $i >= 0; $i--) {
            $date  = now()->subMonths($i);
            $bulanLabels[] = $date->format('M Y');
            $kostumPerBulan[] = DetailTransaksi::whereHas('transaksi', function ($q) use ($date) {
                $q->whereIn('status', ['Sudah Dibayar', 'Disewa', 'Selesai'])
                  ->whereYear('created_at', $date->year)
                  ->whereMonth('created_at', $date->month);
            })->count();
        }

        $transaksi_terbaru = Transaksi::with(['user', 'detailTransaksi.kostum', 'pengembalian'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Pesanan yang butuh perhatian admin: Menunggu Verifikasi
        $pesanan_masuk = Transaksi::with(['user', 'detailTransaksi.kostum'])
            ->whereIn('status', ['Menunggu Verifikasi', 'Menunggu Pembayaran'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Top 5 kostum terlaris
        $top_kostum = DetailTransaksi::with('kostum')
            ->selectRaw('kostum_id, COUNT(*) as total_sewa')
            ->whereHas('transaksi', function ($q) {
                $q->whereIn('status', ['Sudah Dibayar', 'Disewa', 'Selesai']);
            })
            ->groupBy('kostum_id')
            ->orderByDesc('total_sewa')
            ->limit(5)
            ->get();

        $stok_hampir_habis = Kostum::with('kategori')
            ->where('stok_permanen', '<=', 1)
            ->orderBy('stok_permanen', 'asc')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard-admin', compact(
            'stats',
            'transaksi_terbaru',
            'pesanan_masuk',
            'persen_tepat_waktu',
            'tingkat_keterlambatan',
            'total_akun',
            'bulanLabels',
            'kostumPerBulan',
            'stok_hampir_habis',
            'top_kostum'
        ));
    }

    public function forum()
    {
        $posts = ForumPost::with(['user', 'category'])
            ->withCount('comments')
            ->latest()
            ->paginate(15);

        return view('admin.forum-admin', compact('posts'));
    }

    // =====================================================================
    // KOSTUM — CRUD LENGKAP
    // =====================================================================
    public function kostum(Request $request)
    {
        $kategoris  = Kategori::orderBy('nama_kategori')->get();
        $query      = Kostum::with('kategori')->latest();

        if ($request->has('kategori_id') && $request->kategori_id) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->has('q') && $request->q) {
            $query->where('nama_kostum', 'like', '%' . $request->q . '%');
        }

        $sizeFilter = $request->get('size');
        if ($sizeFilter) {
            $query->where('ukuran', 'regexp', '(^|,)[[:space:]]*' . preg_quote($sizeFilter) . '([[:space:]]*|,|$)');
        }

        $lowStockFilter = $request->boolean('low_stock');
        if ($lowStockFilter) {
            $query->where('stok_permanen', '<=', 1);
        }

        $allSizes = Kostum::whereNotNull('ukuran')
            ->pluck('ukuran')
            ->flatMap(fn($u) => array_map('trim', explode(',', $u)))
            ->filter()
            ->unique()
            ->sort()
            ->values();

        $kostums = $query->paginate(12)->withQueryString();

        return view('admin.kostum-admin', compact('kostums', 'kategoris', 'allSizes', 'sizeFilter', 'lowStockFilter'));
    }

    public function kostumStore(Request $request)
    {
        $request->validate([
            'nama_kostum'          => 'required|string|max:255',
            'kategori_id'          => 'required|exists:kategori,id',
            'harga_sewa'           => 'required|integer|min:0',
            'ukuran'               => 'required|string|max:255',
            'stok_per_ukuran'      => 'required|array|min:1',
            'stok_per_ukuran.*'    => 'required|integer|min:0',
            'kelengkapan'          => 'nullable|string',
            'gambar'               => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $gambar = null;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('kostum', 'public');
        }

        $rawStokPerUkuran = $request->input('stok_per_ukuran', []);
        $stokPerUkuran = [];
        $totalStok = 0;
        foreach ($rawStokPerUkuran as $size => $qty) {
            $size = trim($size);
            if ($size !== '') {
                $stokPerUkuran[$size] = (int) $qty;
                $totalStok += (int) $qty;
            }
        }

        $ukuranStr = implode(', ', array_keys($stokPerUkuran));

        Kostum::create([
            'nama_kostum'              => $request->nama_kostum,
            'kategori_id'              => $request->kategori_id,
            'harga_sewa'               => $request->harga_sewa,
            'stok_permanen'            => $totalStok,
            'stok_aktual'              => $totalStok,
            'ukuran'                   => $ukuranStr,
            'stok_permanen_per_ukuran' => $stokPerUkuran,
            'stok_aktual_per_ukuran'   => $stokPerUkuran,
            'kelengkapan'              => $request->kelengkapan,
            'gambar'                   => $gambar,
        ]);

        return redirect()->route('admin.kostum')->with('success', 'Costume added successfully!');
    }

    public function kostumUpdate(Request $request, $id)
    {
        $kostum = Kostum::findOrFail($id);

        $request->validate([
            'nama_kostum'          => 'required|string|max:255',
            'kategori_id'          => 'required|exists:kategori,id',
            'harga_sewa'           => 'required|integer|min:0',
            'ukuran'               => 'required|string|max:255',
            'stok_per_ukuran'      => 'required|array|min:1',
            'stok_per_ukuran.*'    => 'required|integer|min:0',
            'kelengkapan'          => 'nullable|string',
            'gambar'               => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $gambar = $kostum->gambar;

        if ($request->hasFile('gambar')) {
            if ($gambar && !filter_var($gambar, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($gambar);
            }
            $gambar = $request->file('gambar')->store('kostum', 'public');
        }

        $rawStokPerUkuran = $request->input('stok_per_ukuran', []);
        $stokPerUkuran = [];
        $totalStok = 0;
        foreach ($rawStokPerUkuran as $size => $qty) {
            $size = trim($size);
            if ($size !== '') {
                $stokPerUkuran[$size] = (int) $qty;
                $totalStok += (int) $qty;
            }
        }

        $ukuranStr = implode(', ', array_keys($stokPerUkuran));

        $kostum->update([
            'nama_kostum'              => $request->nama_kostum,
            'kategori_id'              => $request->kategori_id,
            'harga_sewa'               => $request->harga_sewa,
            'stok_permanen'            => $totalStok,
            'ukuran'                   => $ukuranStr,
            'stok_permanen_per_ukuran' => $stokPerUkuran,
            'kelengkapan'              => $request->kelengkapan,
            'gambar'                   => $gambar,
        ]);

        // Hitung ulang stok aktual berdasarkan stok permanen yang baru
        $activeStatuses = \App\Models\Kostum::statusAktif();
        $activeDetails = \App\Models\DetailTransaksi::join('transaksi', 'detail_transaksi.transaksi_id', '=', 'transaksi.id')
            ->where('detail_transaksi.kostum_id', $kostum->id)
            ->whereIn('transaksi.status', $activeStatuses)
            ->select('detail_transaksi.ukuran')
            ->get();
        
        $stokAktual = $totalStok;
        $stokAktualPerUkuran = $stokPerUkuran;

        foreach ($activeDetails as $detail) {
            $stokAktual--;
            if ($detail->ukuran && isset($stokAktualPerUkuran[$detail->ukuran])) {
                $stokAktualPerUkuran[$detail->ukuran]--;
            }
        }
        
        $stokAktual = max(0, $stokAktual);
        foreach ($stokAktualPerUkuran as $k => $v) {
            $stokAktualPerUkuran[$k] = max(0, $v);
        }

        $kostum->update([
            'stok_aktual' => $stokAktual,
            'stok_aktual_per_ukuran' => $stokAktualPerUkuran,
        ]);

        return redirect()->route('admin.kostum')->with('success', 'Costume updated successfully!');
    }

    public function kostumDestroy($id)
    {
        $kostum = Kostum::findOrFail($id);

        $kostum->delete();

        return redirect()->route('admin.kostum')->with('success', 'Costume archived successfully!');
    }

    // =====================================================================
    // KATEGORI — CRUD
    // =====================================================================
    public function kategoriStore(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori',
            'franchise'     => 'nullable|string|max:255',
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'franchise'     => $request->franchise,
        ]);

        return redirect()->route('admin.kostum')->with('success', 'Category added successfully!');
    }

    public function kategoriDestroy($id)
    {
        $kategori = Kategori::findOrFail($id);

        if ($kategori->kostum()->count() > 0) {
            return redirect()->route('admin.kostum')
                ->with('error', 'Category cannot be deleted because it still has costumes!');
        }

        $kategori->delete();

        return redirect()->route('admin.kostum')->with('success', 'Category deleted successfully!');
    }

    // =====================================================================
    // PEMBAYARAN — READ + UPDATE STATUS
    // =====================================================================
    public function pembayaran(Request $request)
    {
        $filter = $request->get('status', 'semua');
        $search = trim($request->string('q')->toString());

        $query = Transaksi::with(['user', 'detailTransaksi.kostum'])->latest();

        // Filter berdasarkan tab yang dipilih
        match ($filter) {
            'belum_upload'       => $query->where('status', 'Menunggu Pembayaran'),
            'menunggu_verifikasi'=> $query->where('status', 'Menunggu Verifikasi'),
            'sudah_dibayar'      => $query->where('status', 'Sudah Dibayar'),
            'disewa'             => $query->where('status', 'Disewa'),
            'ditolak'            => $query->where('status', 'Ditolak'),
            default              => null, // 'semua' — tidak filter
        };

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                if (is_numeric($search)) {
                    $q->orWhere('id', (int) $search);
                }
                $q->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('nama', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                })->orWhereHas('detailTransaksi.kostum', function ($kostumQuery) use ($search) {
                    $kostumQuery->where('nama_kostum', 'like', '%' . $search . '%');
                });
            });
        }

        $transaksis = $query->paginate(15)->withQueryString();

        $stats = [
            'belum_upload'        => Transaksi::where('status', 'Menunggu Pembayaran')->count(),
            'menunggu_verifikasi' => Transaksi::where('status', 'Menunggu Verifikasi')->count(),
            'sudah_dibayar'       => Transaksi::where('status', 'Sudah Dibayar')->count(),
            'disewa'              => Transaksi::where('status', 'Disewa')->count(),
            'ditolak'             => Transaksi::where('status', 'Ditolak')->count(),
            'pendapatan'          => Transaksi::whereIn('status', ['Sudah Dibayar', 'Disewa', 'Selesai'])
                                        ->whereDate('created_at', today())
                                        ->sum('total_biaya'),
        ];

        return view('admin.pembayaran-admin', compact('transaksis', 'stats', 'filter'));
    }

    /**
     * Admin approve bukti pembayaran → status: Sudah Dibayar
     * (Kostum BELUM diambil, hanya pembayaran terverifikasi)
     */
    public function pembayaranSetujui(Request $request, $id)
    {
        $transaksi = Transaksi::with('detailTransaksi.kostum')->findOrFail($id);

        if ($transaksi->status !== 'Menunggu Verifikasi') {
            return back()->with('error', 'Only transactions awaiting verification can be approved.');
        }

        if (empty($transaksi->bukti_pembayaran)) {
            return back()->with('error', 'Payment proof is required before approving this transaction.');
        }

        $request->validate([
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            // Status berubah ke 'Sudah Dibayar' — kostum belum diambil
            // Stok TIDAK berubah di sini (sudah dikurangi saat booking)
            $transaksi->update([
                'status'        => 'Sudah Dibayar',
                'catatan_admin' => $request->catatan_admin,
            ]);

            \Illuminate\Support\Facades\DB::commit();

            return redirect()->route('admin.pembayaran')
                ->with('success', "Payment for #TRX-{$id} verified successfully! Please confirm when the costume is picked up.");

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->with('error', "An error occurred: " . $e->getMessage());
        }
    }

    /**
     * Admin tolak bukti pembayaran → status: Menunggu Pembayaran
     * (Pelanggan bisa upload ulang bukti yang benar)
     */
    public function pembayaranTolak(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->status !== 'Menunggu Verifikasi') {
            return back()->with('error', 'Only transactions awaiting verification can be rejected.');
        }

        $request->validate([
            'catatan_admin' => 'required|string|max:500',
        ]);

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            // Hapus bukti lama agar pelanggan upload ulang yang benar
            if ($transaksi->bukti_pembayaran &&
                \Illuminate\Support\Facades\Storage::disk('public')->exists($transaksi->bukti_pembayaran)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($transaksi->bukti_pembayaran);
            }

            // ── PR-2: Slot kalender otomatis terbuka saat status 'Ditolak' ─────
            // Status 'Ditolak' tidak termasuk dalam statusAktif(), sehingga slot
            // kalender untuk tanggal yang sama langsung dapat direbook oleh pelanggan lain.
            // Pelanggan masih dapat upload ulang bukti pembayaran; jika diterima,
            // transaksi akan kembali ke 'Menunggu Verifikasi' dan slot akan terkunci kembali.
            $transaksi->update([
                'status'             => 'Ditolak',
                'bukti_pembayaran'   => null,
                'catatan_admin'      => $request->catatan_admin,
            ]);

            \Illuminate\Support\Facades\DB::commit();

            return redirect()->route('admin.pembayaran', ['status' => 'ditolak'])
                ->with('success', "Payment proof for #TRX-{$id} rejected. Customer requested to re-upload.");

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->with('error', "An error occurred: " . $e->getMessage());
        }
    }

    /**
     * Admin batalkan transaksi sepenuhnya → status: Batal
     * Slot kalender otomatis terbuka karena status berubah ke Batal
     * (tidak memblokir calendar availability).
     */
    public function pembayaranBatal(Request $request, $id)
    {
        $transaksi = Transaksi::with('detailTransaksi.kostum')->findOrFail($id);

        if (!in_array($transaksi->status, ['Menunggu Pembayaran', 'Menunggu Verifikasi', 'Sudah Dibayar'])) {
            return back()->with('error', 'Transaction cannot be cancelled in this status.');
        }

        $request->validate([
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            $transaksi->update([
                'status'        => 'Batal',
                'catatan_admin' => $request->catatan_admin ?? 'Transaction cancelled by admin.',
            ]);

            \Illuminate\Support\Facades\DB::commit();

            return redirect()->route('admin.pembayaran')
                ->with('success', "Transaction #TRX-{$id} has been cancelled successfully. Calendar slot is automatically available again.");

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->with('error', "An error occurred: " . $e->getMessage());
        }
    }

    /**
     * Admin konfirmasi kostum sudah diambil pelanggan → status: Disewa
     * Ini adalah momen kostum benar-benar keluar dari toko.
     */
    public function konfirmasiPengambilan(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->status !== 'Sudah Dibayar') {
            return back()->with('error', 'Only transactions with status "Payment Confirmed" can have their pickup confirmed.');
        }

        $request->validate([
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            $transaksi->update([
                'status'        => 'Disewa',
                'catatan_admin' => $request->catatan_admin,
            ]);

            \Illuminate\Support\Facades\DB::commit();

            return redirect()->route('admin.pembayaran')
                ->with('success', "Costume #TRX-{$id} pickup has been confirmed. Status: Rental Active.");

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->with('error', "An error occurred: " . $e->getMessage());
        }
    }

    // =====================================================================
    // PENGEMBALIAN — READ + CATAT KEMBALI + DENDA OTOMATIS
    // =====================================================================
    public function pengembalian(Request $request)
    {
        $filter = $request->get('filter', 'semua');
        $search = trim($request->string('q')->toString());

        // Hanya tampilkan transaksi Disewa (sudah diambil) atau Selesai
        $query = Transaksi::with(['user', 'detailTransaksi.kostum', 'pengembalian'])
            ->whereIn('status', ['Disewa', 'Selesai'])
            ->latest();

        if ($filter === 'belum') {
            $query->where('status', 'Disewa')->whereDoesntHave('pengembalian');
        } elseif ($filter === 'tepat') {
            $query->where('status', 'Selesai')
                ->whereHas('pengembalian', function ($returnQuery) {
                    $returnQuery->whereColumn('pengembalian.tanggal_kembali_aktual', '<=', 'transaksi.tanggal_selesai');
                });
        } elseif ($filter === 'terlambat') {
            $query->where('status', 'Selesai')
                ->whereHas('pengembalian', function ($returnQuery) {
                    $returnQuery->whereColumn('pengembalian.tanggal_kembali_aktual', '>', 'transaksi.tanggal_selesai');
                });
        } elseif ($filter === 'denda') {
            $query->whereHas('pengembalian', function ($returnQuery) {
                $returnQuery->where('total_denda', '>', 0);
            });
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                if (is_numeric($search)) {
                    $q->orWhere('id', (int) $search);
                }
                $q->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('nama', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                })->orWhereHas('detailTransaksi.kostum', function ($kostumQuery) use ($search) {
                    $kostumQuery->where('nama_kostum', 'like', '%' . $search . '%');
                });
            });
        }

        $transaksis = $query->paginate(15)->withQueryString();

        $stats = [
            'harus_kembali' => Transaksi::where('status', 'Disewa')
                                ->whereDate('tanggal_selesai', today())->count(),
            'sudah_kembali' => Pengembalian::whereDate('tanggal_kembali_aktual', today())->count(),
            'terlambat'     => Transaksi::where('status', 'Disewa')
                                ->whereDate('tanggal_selesai', '<', today())->count(),
            'total_denda'   => Pengembalian::whereMonth('created_at', now()->month)->sum('total_denda'),
        ];

        return view('admin.pengembalian-admin', compact('transaksis', 'stats', 'filter'));
    }

    public function pengembalianKembali(Request $request, $id)
    {
        $transaksi = Transaksi::with(['detailTransaksi.kostum', 'pengembalian'])->findOrFail($id);

        if ($transaksi->status !== 'Disewa') {
            return back()->with('error', 'Only costumes currently rented can be recorded as returned.');
        }

        if ($transaksi->pengembalian) {
            return back()->with('error', 'This transaction return has already been recorded.');
        }

        $request->validate([
            'tanggal_kembali_aktual' => 'required|date',
            'kondisi_kostum'         => 'required|string|max:255',
            'denda_kerusakan'        => 'nullable|integer|min:0',
            'catatan_admin'          => 'nullable|string|max:1000',
        ]);

        $tanggalSelesai = Carbon::parse($transaksi->tanggal_selesai)->startOfDay();
        $tanggalKembali = Carbon::parse($request->tanggal_kembali_aktual)->startOfDay();
        $dendaPerHari   = 50000;

        // Hitung denda keterlambatan OTOMATIS berdasarkan selisih tanggal
        if ($tanggalKembali->lte($tanggalSelesai)) {
            $hariTerlambat      = 0;
            $dendaKeterlambatan = 0;
        } else {
            $hariTerlambat      = (int) abs($tanggalSelesai->diffInDays($tanggalKembali));
            $dendaKeterlambatan = $hariTerlambat * $dendaPerHari;
        }

        // Denda kerusakan diinput MANUAL oleh admin berdasarkan kondisi fisik kostum
        $dendaKerusakan = max(0, (int) ($request->denda_kerusakan ?? 0));

        // Total denda = keterlambatan (auto) + kerusakan (manual)
        $totalDenda = max(0, $dendaKeterlambatan + $dendaKerusakan);

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            Pengembalian::create([
                'transaksi_id'           => $transaksi->id,
                'tanggal_kembali_aktual' => $request->tanggal_kembali_aktual,
                'kondisi_barang'         => $request->kondisi_kostum,
                'catatan_qc'             => $request->catatan_admin,
                'denda_keterlambatan'    => $dendaKeterlambatan,
                'denda_kerusakan'        => $dendaKerusakan,
                'total_denda'            => $totalDenda,
            ]);

            $transaksi->update([
                'status' => 'Selesai',
            ]);

            \Illuminate\Support\Facades\DB::commit();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->with('error', "An error occurred: " . $e->getMessage());
        }

        // Pesan sukses dengan breakdown denda
        $msg = "Return #TRX-{$id} has been recorded successfully.";
        if ($dendaKeterlambatan > 0 || $dendaKerusakan > 0) {
            $msg .= " | Late Fine: Rp " . number_format($dendaKeterlambatan, 0, ',', '.');
            $msg .= " + Damage Fine: Rp " . number_format($dendaKerusakan, 0, ',', '.');
            $msg .= " = Total Fine: Rp " . number_format($totalDenda, 0, ',', '.');
        } else {
            $msg .= ' Returned on time and in good condition, no fines applied.';
        }

        return redirect()->route('admin.pengembalian')
            ->with('success', $msg);
    }

    // =====================================================================
    // PENGGUNA — READ + DELETE
    // =====================================================================
    public function pengguna(Request $request)
    {
        $query = User::where('role', 'pelanggan')->withCount('transaksi');

        if ($request->has('q') && $request->q) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->q . '%')
                  ->orWhere('email', 'like', '%' . $request->q . '%');
            });
        }

        $sort = $request->get('sort', 'terbaru');
        if ($sort === 'terlama') {
            $query->oldest();
        } else {
            $query->latest();
        }

        $pengguna = $query->paginate(15)->withQueryString();

        return view('admin.pengguna-admin', compact('pengguna', 'sort'));
    }

    public function penggunaDestroy($id)
    {
        $user = User::where('role', 'pelanggan')->findOrFail($id);
        $user->delete();

        return redirect()->route('admin.pengguna')->with('success', "User account '{$user->nama}' has been deleted successfully.");
    }

    public function penggunaToggleActive($id)
    {
        $user = User::where('role', 'pelanggan')->findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.pengguna')->with('success', "User account '{$user->nama}' has been successfully {$status}.");
    }

    // =====================================================================
    // RIWAYAT — READ ONLY
    // =====================================================================
    public function riwayat(Request $request)
    {
        $query = User::withTrashed()
            ->where('role', 'pelanggan')
            ->withCount('transaksi')
            ->withSum('transaksi', 'total_biaya')
            ->orderByDesc('transaksi_count');

        if ($request->has('q') && $request->q) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->q . '%')
                  ->orWhere('email', 'like', '%' . $request->q . '%');
            });
        }

        $pengguna = $query->paginate(20)->withQueryString();

        $stats = [
            'total_pelanggan'   => User::where('role', 'pelanggan')->count(),
            'total_order_bulan' => Transaksi::whereMonth('created_at', now()->month)->count(),
            'pelanggan_aktif'   => User::where('role', 'pelanggan')
                ->whereHas('transaksi', function ($q) {
                    $q->where('status', 'Disewa');
                })->count(),
        ];

        return view('admin.riwayat-admin', compact('pengguna', 'stats'));
    }

    // =====================================================================
    // AJAX: Detail transaksi satu user (untuk Riwayat & Pengguna)
    // =====================================================================
    public function riwayatUser($id)
    {
        $user = User::withTrashed()
            ->where('role', 'pelanggan')
            ->findOrFail($id);

        $transaksis = Transaksi::with(['detailTransaksi.kostum', 'pengembalian'])
            ->where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($t) {
                $firstDetail = $t->detailTransaksi->first();
                $kostumNama = $firstDetail?->kostum?->nama_kostum ?? 'N/A';
                if ($firstDetail?->ukuran) {
                    $kostumNama .= " ({$firstDetail->ukuran})";
                }
                $totalDenda = $t->pengembalian?->total_denda ?? 0;
                return [
                    'id'              => $t->id,
                    'kostum'          => $kostumNama,
                    'tanggal_mulai'   => $t->tanggal_mulai?->format('d/m/Y'),
                    'tanggal_selesai' => $t->tanggal_selesai?->format('d/m/Y'),
                    'durasi'          => $t->tanggal_mulai && $t->tanggal_selesai
                                         ? $t->tanggal_mulai->diffInDays($t->tanggal_selesai) . ' hari'
                                         : '-',
                    'total_biaya'     => $t->total_biaya,
                    'total_denda'     => $totalDenda,
                    'status'          => $t->status,
                    'status_label'    => $t->status_label,
                ];
            });

        return response()->json([
            'user'      => [
                'id'              => $user->id,
                'nama'            => $user->nama,
                'email'           => $user->email,
                'no_hp'           => $user->no_hp,
                'avatar'          => $user->avatar
                                      ? asset('storage/' . $user->avatar)
                                      : null,
                'join'            => $user->created_at->format('F Y'),
                'total_transaksi' => $transaksis->count(),
                'total_selesai'   => $transaksis->where('status', 'Selesai')->count(),
                'total_disewa'    => $transaksis->where('status', 'Disewa')->count(),
                'total_bayar'     => $transaksis->sum('total_biaya'),
            ],
            'transaksis' => $transaksis->values(),
        ]);
    }
}
