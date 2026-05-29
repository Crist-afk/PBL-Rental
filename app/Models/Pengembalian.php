<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $table = 'pengembalian';

    protected $fillable = [
        'transaksi_id',
        'tanggal_kembali_aktual',
        'kondisi_barang',
        'catatan_qc',
        'denda_keterlambatan',
        'denda_kerusakan',
        'total_denda',
    ];

    protected $casts = [
        'tanggal_kembali_aktual' => 'date',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }
}
