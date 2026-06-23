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
            ->where('stok', '<=', 1)
            ->orderBy('stok', 'asc')
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
            $query->where('stok', '<=', 1);
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
            'nama_kostum'     => $request->nama_kostum,
            'kategori_id'     => $request->kategori_id,
            'harga_sewa'      => $request->harga_sewa,
            'stok'            => $totalStok,
            'ukuran'          => $ukuranStr,
            'stok_per_ukuran' => $stokPerUkuran,
            'kelengkapan'     => $request->kelengkapan,
            'gambar'          => $gambar,
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
            'nama_kostum'     => $request->nama_kostum,
            'kategori_id'     => $request->kategori_id,
            'harga_sewa'      => $request->harga_sewa,
            'stok'            => $totalStok,
            'ukuran'          => $ukuranStr,
            'stok_per_ukuran' => $stokPerUkuran,
            'kelengkapan'     => $request->kelengkapan,
            'gambar'          => $gambar,
        ]);

        return redirect()->route('admin.kostum')->with('success', 'Costume updated successfully!');
    }

    public function kostumDestroy($id)
    {
        $kostum = Kostum::findOrFail($id);

        if ($kostum->gambar && !filter_var($kostum->gambar, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($kostum->gambar);
        }

        $kostum->delete();

        return redirect()->route('admin.kostum')->with('success', 'Costume deleted successfully!');
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
            return back()->with('error', 'Hanya transaksi yang menunggu verifikasi yang bisa disetujui.');
        }

        if (empty($transaksi->bukti_pembayaran)) {
            return back()->with('error', 'Bukti pembayaran diperlukan sebelum menyetujui transaksi ini.');
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
                ->with('success', "Pembayaran #TRX-{$id} berhasil diverifikasi! Silakan konfirmasi saat kostum diambil.");

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->with('error', "Terjadi kesalahan: " . $e->getMessage());
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
            return back()->with('error', 'Hanya transaksi yang menunggu verifikasi yang bisa ditolak.');
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

            // Set status ke 'Ditolak' — pelanggan bisa lihat alasan & upload ulang
            // Stok TIDAK dikembalikan — slot tetap reserved, pelanggan masih bisa re-upload
            $transaksi->update([
                'status'             => 'Ditolak',
                'bukti_pembayaran'   => null,
                'catatan_admin'      => $request->catatan_admin,
            ]);

            \Illuminate\Support\Facades\DB::commit();

            return redirect()->route('admin.pembayaran', ['status' => 'ditolak'])
                ->with('success', "Bukti pembayaran #TRX-{$id} ditolak. Pelanggan diminta upload ulang.");

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->with('error', "Terjadi kesalahan: " . $e->getMessage());
        }
    }

    /**
     * Admin batalkan transaksi sepenuhnya → status: Batal
     * Stok dikembalikan. Digunakan untuk pembatalan permanen.
     */
    public function pembayaranBatal(Request $request, $id)
    {
        $transaksi = Transaksi::with('detailTransaksi.kostum')->findOrFail($id);

        // Hanya bisa batalkan jika belum disewa / belum diambil
        if (!in_array($transaksi->status, ['Menunggu Pembayaran', 'Menunggu Verifikasi', 'Sudah Dibayar'])) {
            return back()->with('error', 'Transaksi tidak bisa dibatalkan dalam status ini.');
        }

        $request->validate([
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            // Kembalikan stok kostum
            foreach ($transaksi->detailTransaksi as $detail) {
                $kostum = $detail->kostum;
                if ($kostum) {
                    if ($detail->ukuran) {
                        $stokPerUkuran = $kostum->stok_per_ukuran;
                        if (is_array($stokPerUkuran) && isset($stokPerUkuran[$detail->ukuran])) {
                            $stokPerUkuran[$detail->ukuran] += 1;
                            $kostum->stok_per_ukuran = $stokPerUkuran;
                        }
                    }
                    $kostum->stok += 1;
                    $kostum->save();
                }
            }

            $transaksi->update([
                'status'        => 'Batal',
                'catatan_admin' => $request->catatan_admin ?? 'Transaksi dibatalkan oleh admin.',
            ]);

            \Illuminate\Support\Facades\DB::commit();

            return redirect()->route('admin.pembayaran')
                ->with('success', "Transaksi #TRX-{$id} berhasil dibatalkan dan stok dikembalikan.");

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->with('error', "Terjadi kesalahan: " . $e->getMessage());
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
            return back()->with('error', 'Hanya transaksi berstatus "Sudah Dibayar" yang bisa dikonfirmasi pengambilannya.');
        }

        $request->validate([
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            // Kostum diambil — status berubah ke Disewa
            $transaksi->update([
                'status'        => 'Disewa',
                'catatan_admin' => $request->catatan_admin,
            ]);

            \Illuminate\Support\Facades\DB::commit();

            return redirect()->route('admin.pembayaran')
                ->with('success', "Kostum #TRX-{$id} telah dikonfirmasi diambil oleh pelanggan. Status: Sedang Disewa.");

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->with('error', "Terjadi kesalahan: " . $e->getMessage());
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
            return back()->with('error', 'Hanya kostum yang sedang disewa yang bisa dicatat pengembaliannya.');
        }

        if ($transaksi->pengembalian) {
            return back()->with('error', 'Transaksi ini sudah dicatat pengembaliannya.');
        }

        $request->validate([
            'tanggal_kembali_aktual' => 'required|date',
            'kondisi_kostum'         => 'required|string|max:255',
            'catatan_admin'          => 'nullable|string|max:1000',
        ]);

        $tanggalSelesai = Carbon::parse($transaksi->tanggal_selesai)->startOfDay();
        $tanggalKembali = Carbon::parse($request->tanggal_kembali_aktual)->startOfDay();
        $dendaPerHari   = 50000;

        // Hitung denda otomatis
        if ($tanggalKembali->lte($tanggalSelesai)) {
            $hariTerlambat = 0;
            $totalDenda    = 0;
        } else {
            $hariTerlambat = (int) abs($tanggalSelesai->diffInDays($tanggalKembali));
            $totalDenda    = $hariTerlambat * $dendaPerHari;
        }

        $totalDenda = max(0, $totalDenda);

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            // Kembalikan stok kostum
            foreach ($transaksi->detailTransaksi as $detail) {
                $kostum = $detail->kostum;
                if ($kostum) {
                    if ($detail->ukuran) {
                        $stokPerUkuran = $kostum->stok_per_ukuran;
                        if (is_array($stokPerUkuran) && isset($stokPerUkuran[$detail->ukuran])) {
                            $stokPerUkuran[$detail->ukuran] += 1;
                            $kostum->stok_per_ukuran = $stokPerUkuran;
                        }
                    }
                    $kostum->stok += 1;
                    $kostum->save();
                }
            }

            Pengembalian::create([
                'transaksi_id'           => $transaksi->id,
                'tanggal_kembali_aktual' => $request->tanggal_kembali_aktual,
                'kondisi_barang'         => $request->kondisi_kostum,
                'catatan_qc'             => $request->catatan_admin,
                'denda_keterlambatan'    => $totalDenda,
                'denda_kerusakan'        => 0,
                'total_denda'            => $totalDenda,
            ]);

            $transaksi->update([
                'status' => 'Selesai',
            ]);

            \Illuminate\Support\Facades\DB::commit();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->with('error', "Terjadi kesalahan: " . $e->getMessage());
        }

        return redirect()->route('admin.pengembalian')
            ->with('success', "Pengembalian #TRX-{$id} berhasil dicatat." .
                ($totalDenda > 0 ? " Denda: Rp " . number_format($totalDenda, 0, ',', '.') : ' Tepat waktu, tidak ada denda.'));
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

        return redirect()->route('admin.pengguna')->with('success', "Akun pengguna '{$user->nama}' berhasil dihapus.");
    }

    public function penggunaToggleActive($id)
    {
        $user = User::where('role', 'pelanggan')->findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.pengguna')->with('success', "Akun '{$user->nama}' berhasil {$status}.");
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
