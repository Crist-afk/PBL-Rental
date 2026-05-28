<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KostumImage extends Model
{
    protected $fillable = [
        'kostum_id',
        'gambar',
        'keterangan',
    ];

    public function kostum()
    {
        return $this->belongsTo(Kostum::class, 'kostum_id');
    }
}
