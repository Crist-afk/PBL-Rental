<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kostum;
use App\Models\Kategori;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
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

        $transaksi_terbaru = Transaksi::with(['user', 'detailTransaksi.kostum'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $pesanan_masuk = Transaksi::with(['user', 'detailTransaksi.kostum'])
            ->where('status', 'Menunggu Pembayaran')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard-admin', compact('stats', 'transaksi_terbaru', 'pesanan_masuk'));
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

        return redirect()->route('admin.kostum')->with('success', 'Kostum berhasil ditambahkan!');
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

        return redirect()->route('admin.kostum')->with('success', 'Kostum berhasil diperbarui!');
    }

    public function kostumDestroy($id)
    {
        $kostum = Kostum::findOrFail($id);

        // Hapus file foto lokal jika ada
        if ($kostum->gambar && !filter_var($kostum->gambar, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($kostum->gambar);
        }

        $kostum->delete();

        return redirect()->route('admin.kostum')->with('success', 'Kostum berhasil dihapus!');
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

        return redirect()->route('admin.kostum')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function kategoriDestroy($id)
    {
        $kategori = Kategori::findOrFail($id);

        // Cek apakah masih ada kostum di kategori ini
        if ($kategori->kostum()->count() > 0) {
            return redirect()->route('admin.kostum')
                ->with('error', 'Kategori tidak bisa dihapus karena masih memiliki kostum!');
        }

        $kategori->delete();

        return redirect()->route('admin.kostum')->with('success', 'Kategori berhasil dihapus!');
    }

    // =====================================================================
    // PEMBAYARAN — READ + UPDATE STATUS
    // =====================================================================
    public function pembayaran(Request $request)
    {
        $filter = $request->get('status', 'semua');

        $query = Transaksi::with(['user', 'detailTransaksi.kostum'])->latest();

        if ($filter === 'menunggu') {
            $query->where('status', 'Menunggu Pembayaran');
        } elseif ($filter === 'dikonfirmasi') {
            $query->where('status', 'Disewa');
        } elseif ($filter === 'ditolak') {
            $query->where('status', 'Batal');
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
        $transaksi = Transaksi::findOrFail($id);

        $request->validate([
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        $transaksi->update([
            'status'         => 'Disewa',
            'catatan_admin'  => $request->catatan_admin,
        ]);

        return redirect()->route('admin.pembayaran')->with('success', "Pembayaran #TRX-{$id} berhasil dikonfirmasi!");
    }

    public function pembayaranTolak(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $request->validate([
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        // Kembalikan stok kostum
        foreach ($transaksi->detailTransaksi as $detail) {
            if ($detail->kostum) {
                $detail->kostum->increment('stok');
            }
        }

        $transaksi->update([
            'status'        => 'Batal',
            'catatan_admin' => $request->catatan_admin,
        ]);

        return redirect()->route('admin.pembayaran')->with('success', "Pembayaran #TRX-{$id} berhasil ditolak.");
    }

    // =====================================================================
    // PENGEMBALIAN — READ + CATAT KEMBALI + DENDA
    // =====================================================================
    public function pengembalian(Request $request)
    {
        $filter = $request->get('filter', 'semua');

        // Ambil transaksi yang statusnya Disewa (belum dikembalikan) atau Selesai (sudah)
        $query = Transaksi::with(['user', 'detailTransaksi.kostum'])
            ->whereIn('status', ['Disewa', 'Selesai'])
            ->latest();

        if ($filter === 'belum') {
            $query->where('status', 'Disewa')->whereNull('tanggal_kembali_aktual');
        } elseif ($filter === 'tepat') {
            $query->where('status', 'Selesai')->whereColumn('tanggal_kembali_aktual', '<=', 'tanggal_selesai');
        } elseif ($filter === 'terlambat') {
            $query->where('status', 'Selesai')->whereColumn('tanggal_kembali_aktual', '>', 'tanggal_selesai');
        } elseif ($filter === 'denda') {
            $query->where('total_denda', '>', 0);
        }

        $transaksis = $query->paginate(15)->withQueryString();

        // Hitung stat cards
        $stats = [
            'harus_kembali' => Transaksi::where('status', 'Disewa')
                                ->whereDate('tanggal_selesai', today())->count(),
            'sudah_kembali' => Transaksi::where('status', 'Selesai')
                                ->whereDate('tanggal_kembali_aktual', today())->count(),
            'terlambat'     => Transaksi::where('status', 'Disewa')
                                ->whereDate('tanggal_selesai', '<', today())->count(),
            'total_denda'   => Transaksi::whereMonth('updated_at', now()->month)->sum('total_denda'),
        ];

        return view('admin.pengembalian-admin', compact('transaksis', 'stats', 'filter'));
    }

    public function pengembalianKembali(Request $request, $id)
    {
        $transaksi = Transaksi::with('detailTransaksi.kostum')->findOrFail($id);

        $request->validate([
            'tanggal_kembali_aktual' => 'required|date',
            'kondisi_kostum'         => 'required|in:Baik,Lecet,Rusak',
            'catatan_admin'          => 'nullable|string|max:500',
        ]);

        $tanggalSelesai = Carbon::parse($transaksi->tanggal_selesai);
        $tanggalKembali = Carbon::parse($request->tanggal_kembali_aktual);
        $dendaPerHari   = 50000; // Rp 50.000 per hari keterlambatan

        $totalDenda = 0;
        if ($tanggalKembali->gt($tanggalSelesai)) {
            $hariTerlambat = $tanggalKembali->diffInDays($tanggalSelesai);
            $totalDenda    = $hariTerlambat * $dendaPerHari;
        }

        // Kembalikan stok kostum
        foreach ($transaksi->detailTransaksi as $detail) {
            if ($detail->kostum) {
                $detail->kostum->increment('stok');
            }
        }

        $transaksi->update([
            'status'                 => 'Selesai',
            'tanggal_kembali_aktual' => $request->tanggal_kembali_aktual,
            'kondisi_kostum'         => $request->kondisi_kostum,
            'total_denda'            => $totalDenda,
            'catatan_admin'          => $request->catatan_admin,
        ]);

        return redirect()->route('admin.pengembalian')
            ->with('success', "Pengembalian #TRX-{$id} berhasil dicatat." .
                ($totalDenda > 0 ? " Denda: Rp " . number_format($totalDenda, 0, ',', '.') : ''));
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

        return redirect()->route('admin.pengguna')->with('success', "Akun pengguna '{$user->nama}' berhasil dihapus.");
    }

    // =====================================================================
    // RIWAYAT — READ ONLY
    // =====================================================================
    public function riwayat(Request $request)
    {
        $query = User::where('role', 'pelanggan')
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
        $user = User::where('role', 'pelanggan')->findOrFail($id);

        $transaksis = Transaksi::with('detailTransaksi.kostum')
            ->where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($t) {
                $kostumNama = $t->detailTransaksi->first()?->kostum?->nama_kostum ?? 'N/A';
                return [
                    'id'             => $t->id,
                    'kostum'         => $kostumNama,
                    'tanggal_mulai'  => $t->tanggal_mulai?->format('d/m/Y'),
                    'tanggal_selesai'=> $t->tanggal_selesai?->format('d/m/Y'),
                    'durasi'         => $t->tanggal_mulai && $t->tanggal_selesai
                                        ? $t->tanggal_mulai->diffInDays($t->tanggal_selesai) . ' hari'
                                        : '-',
                    'total_biaya'    => $t->total_biaya,
                    'total_denda'    => $t->total_denda,
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
