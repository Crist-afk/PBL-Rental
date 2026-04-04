<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kostum;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function store(Request $request)
    {
        // 1. VALIDASI INPUT BRUTAL
        $request->validate([
            'kostum_id'      => 'required|exists:kostum,id',
            'tanggal_mulai'  => 'required|date|after_or_equal:today',
            'tanggal_selesai'=> 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;
        $kostumId = $request->kostum_id;

        // 2. MULAI DATABASE TRANSACTION
        try {
            DB::beginTransaction();

            // 3. PESSIMISTIC LOCKING
            // Kunci baris kostum ini di database. Request dari user lain yang mengincar
            // kostum yang sama akan dipaksa mengantri sampai transaksi ini selesai.
            $kostum = Kostum::where('id', $kostumId)->lockForUpdate()->first();

            if (!$kostum) {
                throw new \Exception('Kostum tidak ditemukan.');
            }

            // 4. VALIDASI IRISAN WAKTU (OVERLAPPING DATES)
            // Mengecek apakah kostum ini sudah ada di detail_transaksi pada rentang tanggal yang diminta.
            $isBooked = Transaksi::whereHas('detailTransaksi', function($query) use ($kostumId) {
                $query->where('kostum_id', $kostumId);
            })->where(function($query) use ($tanggalMulai, $tanggalSelesai) {
                // Logika Anti-Irisan Waktu: (ExistingStart <= RequestEnd) AND (ExistingEnd >= RequestStart)
                $query->where('tanggal_mulai', '<=', $tanggalSelesai)
                    ->where('tanggal_selesai', '>=', $tanggalMulai);
            })->exists();

            if ($isBooked) {
                throw new \Exception('Kostum sudah di-booking pada tanggal tersebut. Silakan pilih tanggal lain.');
            }

            // 5. KALKULASI TOTAL BIAYA (Menggunakan Carbon untuk selisih hari)
            $start = Carbon::parse($tanggalMulai);
            $end = Carbon::parse($tanggalSelesai);
            // Tambah 1 karena pinjam tanggal 1 sampai 1 dihitung 1 hari sewa
            $durasiHari = $start->diffInDays($end) + 1;

            $totalBiaya = $durasiHari * $kostum->harga_sewa;

            // 6. SIMPAN HEADER TRANSAKSI
            $transaksi = Transaksi::create([
                'user_id'         => Auth::id(), // Pastikan user sudah login (auth middleware)
                'tanggal_mulai'   => $tanggalMulai,
                'tanggal_selesai' => $tanggalSelesai,
                'total_biaya'     => $totalBiaya,
                'status'          => 'Menunggu Pembayaran' // Atau sesuaikan dengan sistem statusmu
            ]);

            // 7. SIMPAN DETAIL TRANSAKSI (Mengunci harga master)
            DetailTransaksi::create([
                'transaksi_id'               => $transaksi->id,
                'kostum_id'                  => $kostum->id,
                'harga_sewa_saat_transaksi'  => $kostum->harga_sewa
            ]);

            // 8. COMMIT TRANSAKSI (Semua aman, simpan permanen ke DB)
            DB::commit();

            // Arahkan Akbar untuk menangani route redirect ini, dan Rangga untuk menampilkan pesannya
            return redirect()->route('transaksi.index')->with('success', 'Booking berhasil!');

        } catch (\Exception $e) {
            // JIKA TERJADI ERROR/BENTROK, BATALKAN SEMUA QUERY
            DB::rollBack();

            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
