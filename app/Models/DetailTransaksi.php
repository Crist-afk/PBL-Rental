<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi';

    protected $guarded = ['id'];

    // Relation to parent Transaksi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }

    // Relation to parent Kostum
    public function kostum()
    {
        return $this->belongsTo(Kostum::class, 'kostum_id')->withTrashed();
    }

    // Relation to specific KostumUnit (costume + size combination)
    public function kostumUnit()
    {
        return $this->belongsTo(KostumUnit::class, 'kostum_unit_id');
    }
}
