<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'user_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'total_biaya',
        'total_denda',
        'status',
        'catatan',
        'bukti_pembayaran',
        'catatan_admin',
        'tanggal_kembali_aktual',
        'kondisi_kostum',
    ];

    protected $casts = [
        'tanggal_mulai'          => 'date',
        'tanggal_selesai'        => 'date',
        'tanggal_kembali_aktual' => 'date',
    ];

    // ── Accessors: label & warna status yang konsisten ──────────────────

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'Menunggu Pembayaran' => 'Waiting for Payment',
            'Disewa'              => 'Rented',
            'Selesai'             => 'Completed',
            'Batal'               => 'Canceled',
            default               => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'Menunggu Pembayaran' => 'bg-amber-100 text-amber-700 border-amber-200',
            'Disewa'              => 'bg-blue-100 text-blue-700 border-blue-200',
            'Selesai'             => 'bg-green-100 text-green-700 border-green-200',
            'Batal'               => 'bg-red-100 text-red-700 border-red-200',
            default               => 'bg-gray-100 text-gray-700 border-gray-200',
        };
    }

    // ── Relasi ──────────────────────────────────────────────────────────

    // Relasi: Satu transaksi dimiliki oleh satu user (Pelanggan)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi: Satu transaksi punya banyak detail barang yang disewa
    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id');
    }
}
