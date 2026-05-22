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
        // Kolom baru untuk pembayaran & pengembalian admin
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
