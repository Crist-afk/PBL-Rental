<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kostum extends Model
{
    protected $table = 'kostum'; // Pastikan nama tabel spesifik

    // GUARDED: Kolom 'id' diabaikan dari input form, sisanya boleh diisi.
    // Ini lebih efisien daripada menulis $fillable satu per satu jika kolomnya banyak.
    protected $guarded = ['id'];

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
