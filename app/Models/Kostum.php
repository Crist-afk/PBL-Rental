<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kostum extends Model
{
    protected $table = 'kostum';

    protected $fillable = [
        'kategori_id',
        'nama_kostum',
        'stok',
        'harga_sewa',
        'ukuran',
        'kelengkapan',
        'gambar'
    ];

    // Relasi: Satu kostum dimiliki oleh satu kategori (BelongsTo)
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    // Relasi: Satu kostum bisa memiliki banyak detail transaksi
    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'kostum_id');
    }
}
