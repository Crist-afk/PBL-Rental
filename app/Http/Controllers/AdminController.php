<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kostum;
use App\Models\Kategori;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Pengembalian;
use App\Models\User;
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
            'total_kostum'      => Kostum::count(),
            'total_pelanggan'   => User::where('role', 'pelanggan')->count(),
            'sewa_aktif'        => Transaksi::where('status', 'Disewa')->count(),
            'menunggu_bayar'    => Transaksi::where('status', 'Menunggu Pembayaran')->count(),
            'total_pendapatan'  => Transaksi::whereIn('status', ['Disewa', 'Selesai'])->sum('total_biaya'),
        ];

        // ── Statistik Cepat (data nyata) ────────────────────────────────
        $totalSelesai = Transaksi::where('status', 'Selesai')->count();

        // Pelanggan tepat waktu: transaksi Selesai yang punya pengembalian on-time
        // (tanggal_kembali_aktual <= tanggal_selesai)
        $tepat_waktu = Pengembalian::whereHas('transaksi', function ($q) {
            $q->where('status', 'Selesai')
              ->whereColumn('pengembalian.tanggal_kembali_aktual', '<=', 'transaksi.tanggal_selesai');
        })->count();

        $persen_tepat_waktu = $totalSelesai > 0
            ? round(($tepat_waktu / $totalSelesai) * 100, 1)
            : 0;

        // Tingkat keterlambatan (%) dari semua yang sudah selesai
        $terlambat_count = Pengembalian::whereHas('transaksi', function ($q) {
            $q->where('status', 'Selesai')
              ->whereColumn('pengembalian.tanggal_kembali_aktual', '>', 'transaksi.tanggal_selesai');
        })->count();

        $tingkat_keterlambatan = $totalSelesai > 0
            ? round(($terlambat_count / $totalSelesai) * 100, 1)
            : 0;

        // Total akun terdaftar
        $total_akun = User::count();

        // ── Chart: Kostum dipesan per bulan (12 bulan terakhir) ──────────
        $kostumPerBulan = [];
        $bulanLabels    = [];
        for ($i = 11; $i >= 0; $i--) {
            $date  = now()->subMonths($i);
            $bulanLabels[] = $date->format('M Y');
            $kostumPerBulan[] = DetailTransaksi::whereHas('transaksi', function ($q) use ($date) {
                $q->whereIn('status', ['Disewa', 'Selesai'])
                  ->whereYear('created_at', $date->year)
                  ->whereMonth('created_at', $date->month);
            })->count();
        }

        $transaksi_terbaru = Transaksi::with(['user', 'detailTransaksi.kostum', 'pengembalian'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $pesanan_masuk = Transaksi::with(['user', 'detailTransaksi.kostum'])
            ->where('status', 'Menunggu Pembayaran')
            ->orderBy('created_at', 'desc')
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
            'kostumPerBulan'
        ));
    }

    // =====================================================================
    // KOSTUM — CRUD LENGKAP
    // =====================================================================
    public function kostum(Request $request)
    {
        $kategoris  = Kategori::orderBy('nama_kategori')->get();
        $query      = Kostum::with('kategori')->latest();

        // Filter kategori via tab
        if ($request->has('kategori_id') && $request->kategori_id) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Search
        if ($request->has('q') && $request->q) {
            $query->where('nama_kostum', 'like', '%' . $request->q . '%');
        }

        $kostums = $query->paginate(12)->withQueryString();

        return view('admin.kostum-admin', compact('kostums', 'kategoris'));
    }

    public function kostumStore(Request $request)
    {
        $request->validate([
            'nama_kostum'  => 'required|string|max:255',
            'kategori_id'  => 'required|exists:kategori,id',
            'harga_sewa'   => 'required|integer|min:0',
            'stok'         => 'required|integer|min:0',
            'ukuran'       => 'required|string|max:50',
            'kelengkapan'  => 'nullable|string',
            'gambar'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $gambar = null;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('kostum', 'public');
        }

        $ukuranArr = array_map('trim', explode(',', $request->ukuran));
        $stokPerUkuran = [];
        $totalUkuran = count($ukuranArr);
        if ($totalUkuran > 0 && $request->stok > 0) {
            $baseStok = floor($request->stok / $totalUkuran);
            $sisaStok = $request->stok % $totalUkuran;
            foreach ($ukuranArr as $index => $u) {
                if (!empty($u)) {
                    $stokPerUkuran[$u] = (int)($baseStok + ($index < $sisaStok ? 1 : 0));
                }
            }
        }

        Kostum::create([
            'nama_kostum'     => $request->nama_kostum,
            'kategori_id'     => $request->kategori_id,
            'harga_sewa'      => $request->harga_sewa,
            'stok'            => $request->stok,
            'ukuran'          => $request->ukuran,
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
            'nama_kostum'  => 'required|string|max:255',
            'kategori_id'  => 'required|exists:kategori,id',
            'harga_sewa'   => 'required|integer|min:0',
            'stok'         => 'required|integer|min:0',
            'ukuran'       => 'required|string|max:50',
            'kelengkapan'  => 'nullable|string',
            'gambar'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $gambar = $kostum->gambar;

        // Hapus gambar lama jika ada gambar baru & gambar lama bukan URL eksternal
        if ($request->hasFile('gambar')) {
            if ($gambar && !filter_var($gambar, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($gambar);
            }
            $gambar = $request->file('gambar')->store('kostum', 'public');
        }

        $ukuranArr = array_map('trim', explode(',', $request->ukuran));
        $stokPerUkuran = [];
        $totalUkuran = count($ukuranArr);
        if ($totalUkuran > 0 && $request->stok > 0) {
            $baseStok = floor($request->stok / $totalUkuran);
            $sisaStok = $request->stok % $totalUkuran;
            foreach ($ukuranArr as $index => $u) {
                if (!empty($u)) {
                    $stokPerUkuran[$u] = (int)($baseStok + ($index < $sisaStok ? 1 : 0));
                }
            }
        }

        $kostum->update([
            'nama_kostum'     => $request->nama_kostum,
            'kategori_id'     => $request->kategori_id,
            'harga_sewa'      => $request->harga_sewa,
            'stok'            => $request->stok,
            'ukuran'          => $request->ukuran,
            'stok_per_ukuran' => $stokPerUkuran,
            'kelengkapan'     => $request->kelengkapan,
            'gambar'          => $gambar,
        ]);

        return redirect()->route('admin.kostum')->with('success', 'Costume updated successfully!');
    }

    public function kostumDestroy($id)
    {
        $kostum = Kostum::findOrFail($id);

        // Hapus file foto lokal jika ada
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

        // Cek apakah masih ada kostum di kategori ini
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

        if ($filter === 'menunggu') {
            $query->where('status', 'Menunggu Pembayaran');
        } elseif ($filter === 'dikonfirmasi') {
            $query->where('status', 'Disewa');
        } elseif ($filter === 'ditolak') {
            $query->where('status', 'Batal');
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
            'menunggu'    => Transaksi::where('status', 'Menunggu Pembayaran')->count(),
            'dikonfirmasi'=> Transaksi::where('status', 'Disewa')->count(),
            'ditolak'     => Transaksi::where('status', 'Batal')->count(),
            'pendapatan'  => Transaksi::whereIn('status', ['Disewa', 'Selesai'])
                                ->whereDate('created_at', today())
                                ->sum('total_biaya'),
        ];

        return view('admin.pembayaran-admin', compact('transaksis', 'stats', 'filter'));
    }

    public function pembayaranSetujui(Request $request, $id)
    {
        $transaksi = Transaksi::with('detailTransaksi.kostum')->findOrFail($id);

        if ($transaksi->status !== 'Menunggu Pembayaran') {
            return back()->with('error', 'Only transactions waiting for payment can be approved.');
        }

        if (empty($transaksi->bukti_pembayaran)) {
            return back()->with('error', 'Payment proof is required before approving this transaction.');
        }

        $request->validate([
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            // Stock has been decreased when user books the costume (in DashboardPelangganController)

            $transaksi->update([
                'status'         => 'Disewa',
                'catatan_admin'  => $request->catatan_admin,
            ]);

            \Illuminate\Support\Facades\DB::commit();

            return redirect()->route('admin.pembayaran')->with('success', "Payment #TRX-{$id} confirmed successfully!");

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->with('error', "An error occurred: " . $e->getMessage());
        }
    }

    public function pembayaranTolak(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->status !== 'Menunggu Pembayaran') {
            return back()->with('error', 'Only transactions waiting for payment can be rejected.');
        }

        $request->validate([
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            // Return costume stock because the transaction is rejected
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
                'catatan_admin' => $request->catatan_admin,
            ]);

            \Illuminate\Support\Facades\DB::commit();

            return redirect()->route('admin.pembayaran')->with('success', "Payment #TRX-{$id} rejected successfully.");

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->with('error', "An error occurred: " . $e->getMessage());
        }
    }

    // =====================================================================
    // PENGEMBALIAN — READ + CATAT KEMBALI + DENDA
    // =====================================================================
    public function pengembalian(Request $request)
    {
        $filter = $request->get('filter', 'semua');
        $search = trim($request->string('q')->toString());

        // Ambil transaksi yang statusnya Disewa (belum dikembalikan) atau Selesai (sudah)
        $query = Transaksi::with(['user', 'detailTransaksi.kostum', 'pengembalian'])
            ->whereIn('status', ['Disewa', 'Selesai'])
            ->latest();

        if ($filter === 'belum') {
            $query->where('status', 'Disewa')->whereDoesntHave('pengembalian');
        } elseif ($filter === 'tepat') {
            $query->where('status', 'Selesai')
                ->where(function ($q) {
                    $q->whereHas('pengembalian', function ($returnQuery) {
                        $returnQuery->whereColumn('pengembalian.tanggal_kembali_aktual', '<=', 'transaksi.tanggal_selesai');
                    })->orWhere(function ($legacyQuery) {
                        $legacyQuery->whereDoesntHave('pengembalian')
                            ->whereNotNull('transaksi.tanggal_kembali_aktual')
                            ->whereColumn('transaksi.tanggal_kembali_aktual', '<=', 'transaksi.tanggal_selesai');
                    });
                });
        } elseif ($filter === 'terlambat') {
            $query->where('status', 'Selesai')
                ->where(function ($q) {
                    $q->whereHas('pengembalian', function ($returnQuery) {
                        $returnQuery->whereColumn('pengembalian.tanggal_kembali_aktual', '>', 'transaksi.tanggal_selesai');
                    })->orWhere(function ($legacyQuery) {
                        $legacyQuery->whereDoesntHave('pengembalian')
                            ->whereNotNull('transaksi.tanggal_kembali_aktual')
                            ->whereColumn('transaksi.tanggal_kembali_aktual', '>', 'transaksi.tanggal_selesai');
                    });
                });
        } elseif ($filter === 'denda') {
            $query->where(function ($q) {
                $q->whereHas('pengembalian', function ($returnQuery) {
                    $returnQuery->where('total_denda', '>', 0);
                })->orWhere(function ($legacyQuery) {
                    $legacyQuery->whereDoesntHave('pengembalian')
                        ->where('total_denda', '>', 0);
                });
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

        // Hitung stat cards
        $stats = [
            'harus_kembali' => Transaksi::where('status', 'Disewa')
                                ->whereDate('tanggal_selesai', today())->count(),
            'sudah_kembali' => Pengembalian::whereDate('tanggal_kembali_aktual', today())->count()
                                + Transaksi::where('status', 'Selesai')
                                    ->whereDoesntHave('pengembalian')
                                    ->whereDate('tanggal_kembali_aktual', today())
                                    ->count(),
            'terlambat'     => Transaksi::where('status', 'Disewa')
                                ->whereDate('tanggal_selesai', '<', today())->count(),
            'total_denda'   => Pengembalian::whereMonth('created_at', now()->month)->sum('total_denda')
                                + Transaksi::whereDoesntHave('pengembalian')
                                    ->whereMonth('updated_at', now()->month)
                                    ->sum('total_denda'),
        ];

        return view('admin.pengembalian-admin', compact('transaksis', 'stats', 'filter'));
    }

    public function pengembalianKembali(Request $request, $id)
    {
        $transaksi = Transaksi::with(['detailTransaksi.kostum', 'pengembalian'])->findOrFail($id);

        if ($transaksi->status !== 'Disewa') {
            return back()->with('error', 'Only active rentals can be returned.');
        }

        if ($transaksi->pengembalian) {
            return back()->with('error', 'This rental has already been returned.');
        }

        $request->validate([
            'tanggal_kembali_aktual' => 'required|date',
            'kondisi_kostum'         => 'required|string|max:255',
            'catatan_admin'          => 'nullable|string|max:1000',
        ]);

        // Normalisasi ke awal hari agar perbandingan tanggal tidak terpengaruh komponen waktu
        $tanggalSelesai = Carbon::parse($transaksi->tanggal_selesai)->startOfDay();
        $tanggalKembali = Carbon::parse($request->tanggal_kembali_aktual)->startOfDay();
        $dendaPerHari   = 50000; // Rp 50.000 per hari keterlambatan

        // VALIDASI BISNIS: Jika kembali tepat waktu atau lebih awal, TIDAK ada denda
        if ($tanggalKembali->lte($tanggalSelesai)) {
            $hariTerlambat = 0;
            $totalDenda    = 0;
        } else {
            $hariTerlambat = (int) abs($tanggalSelesai->diffInDays($tanggalKembali));
            $totalDenda    = $hariTerlambat * $dendaPerHari;
        }

        // Safety net: pastikan denda tidak pernah bernilai negatif
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
                'transaksi_id'             => $transaksi->id,
                'tanggal_kembali_aktual'   => $request->tanggal_kembali_aktual,
                'kondisi_barang'           => $request->kondisi_kostum,
                'catatan_qc'               => $request->catatan_admin,
                'denda_keterlambatan'      => $totalDenda,
                'denda_kerusakan'          => 0,
                'total_denda'              => $totalDenda,
            ]);

            $transaksi->update([
                'status' => 'Selesai',
            ]);

            \Illuminate\Support\Facades\DB::commit();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->with('error', "An error occurred: " . $e->getMessage());
        }

        return redirect()->route('admin.pengembalian')
            ->with('success', "Return #TRX-{$id} recorded successfully." .
                ($totalDenda > 0 ? " Fine: Rp " . number_format($totalDenda, 0, ',', '.') : ''));
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

        // Sorting
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

        return redirect()->route('admin.pengguna')->with('success', "User account '{$user->nama}' deleted successfully.");
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
            'total_pelanggan' => User::where('role', 'pelanggan')->count(),
            'total_order_bulan' => Transaksi::whereMonth('created_at', now()->month)->count(),
            'pelanggan_aktif' => User::where('role', 'pelanggan')
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
                $totalDenda = $t->pengembalian?->total_denda ?? $t->total_denda;
                return [
                    'id'             => $t->id,
                    'kostum'         => $kostumNama,
                    'tanggal_mulai'  => $t->tanggal_mulai?->format('d/m/Y'),
                    'tanggal_selesai'=> $t->tanggal_selesai?->format('d/m/Y'),
                    'durasi'         => $t->tanggal_mulai && $t->tanggal_selesai
                                        ? $t->tanggal_mulai->diffInDays($t->tanggal_selesai) . ' hari'
                                        : '-',
                    'total_biaya'    => $t->total_biaya,
                    'total_denda'    => $totalDenda,
                    'status'         => $t->status,
                ];
            });

        return response()->json([
            'user'      => [
                'id'        => $user->id,
                'nama'      => $user->nama,
                'email'     => $user->email,
                'no_hp'     => $user->no_hp,
                'avatar'    => $user->avatar
                                ? asset('storage/' . $user->avatar)
                                : null,
                'join'      => $user->created_at->format('F Y'),
                'total_transaksi' => $transaksis->count(),
                'total_selesai'   => $transaksis->where('status', 'Selesai')->count(),
                'total_disewa'    => $transaksis->where('status', 'Disewa')->count(),
                'total_bayar'     => $transaksis->sum('total_biaya'),
            ],
            'transaksis' => $transaksis->values(),
        ]);
    }
}
