<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'user_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'total_biaya',
        'status',
        'catatan',
        'bukti_pembayaran',
        'catatan_admin',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
    ];

    // ── Accessors: label & warna status yang konsisten ──────────────────

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'Menunggu Pembayaran' => 'Awaiting Payment',
            'Menunggu Verifikasi' => 'Awaiting Verification',
            'Ditolak'             => 'Rejected',
            'Sudah Dibayar'       => 'Payment Confirmed',
            'Disewa'              => 'Rental Active',
            'Selesai'             => 'Completed',
            'Batal'               => 'Cancelled',
            default               => $this->status,
        };
    }

    public function getStatusLabelEnAttribute(): string
    {
        return match ($this->status) {
            'Menunggu Pembayaran' => 'Waiting for Payment',
            'Menunggu Verifikasi' => 'Awaiting Verification',
            'Ditolak'             => 'Proof Rejected',
            'Sudah Dibayar'       => 'Payment Confirmed',
            'Disewa'              => 'Rented',
            'Selesai'             => 'Returned',
            'Batal'               => 'Canceled',
            default               => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'Menunggu Pembayaran' => 'bg-red-100 text-red-700 border-red-200',
            'Menunggu Verifikasi' => 'bg-amber-100 text-amber-700 border-amber-200',
            'Ditolak'             => 'bg-rose-100 text-rose-700 border-rose-200',
            'Sudah Dibayar'       => 'bg-emerald-100 text-emerald-700 border-emerald-200',
            'Disewa'              => 'bg-blue-100 text-blue-700 border-blue-200',
            'Selesai'             => 'bg-gray-100 text-gray-700 border-gray-200',
            'Batal'               => 'bg-red-100 text-red-700 border-red-200',
            default               => 'bg-gray-100 text-gray-700 border-gray-200',
        };
    }

    /**
     * Hitung denda otomatis berdasarkan hari ini.
     * Hanya berlaku untuk transaksi 'Disewa' yang melewati tanggal_selesai.
     */
    public function getDendaOtomatisAttribute(): int
    {
        if ($this->status !== 'Disewa') {
            return 0;
        }

        $today       = Carbon::today();
        $tglSelesai  = Carbon::parse($this->tanggal_selesai)->startOfDay();

        if ($today->lte($tglSelesai)) {
            return 0;
        }

        $hariTerlambat = (int) $tglSelesai->diffInDays($today);
        return max(0, $hariTerlambat * 50000);
    }

    public function getDaysLateAttribute(): int
    {
        if ($this->status !== 'Disewa') {
            return 0;
        }

        $today      = Carbon::today();
        $tglSelesai = Carbon::parse($this->tanggal_selesai)->startOfDay();

        if ($today->lte($tglSelesai)) {
            return 0;
        }

        return (int) $tglSelesai->diffInDays($today);
    }

    // ── Relasi ──────────────────────────────────────────────────────────

    // Relasi: Satu transaksi dimiliki oleh satu user (Pelanggan)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    // Relasi: Satu transaksi punya banyak detail barang yang disewa
    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id');
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'transaksi_id');
    }
}
