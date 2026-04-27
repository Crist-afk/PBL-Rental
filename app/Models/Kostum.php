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

    /**
     * Accessor untuk mendapatkan URL gambar yang valid.
     * Mendukung link eksternal (http/https) maupun file lokal di storage.
     */
    public function getGambarUrlAttribute()
    {
        if (!$this->gambar) {
            return 'https://via.placeholder.com/400x500.png?text=No+Image';
        }

        if (filter_var($this->gambar, FILTER_VALIDATE_URL)) {
            return $this->gambar;
        }

        return asset('storage/kostum/' . $this->gambar);
    }
}
