<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    // Pastikan nama tabel di database menggunakan snake_case
    protected $table = 'detail_transaksi';

    protected $guarded = ['id'];

    // Relasi ke tabel Transaksi Induk
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }

    // Relasi ke tabel Kostum
    public function kostum()
    {
        return $this->belongsTo(Kostum::class, 'kostum_id');
    }
}
