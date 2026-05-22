<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';

    protected $fillable = [
        'nama_kategori',
        'franchise',
    ];

    // Relasi: Satu kategori memiliki banyak kostum
    public function kostum()
    {
        return $this->hasMany(Kostum::class, 'kategori_id');
    }
}
