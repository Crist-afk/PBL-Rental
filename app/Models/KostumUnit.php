<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KostumUnit extends Model
{
    protected $table = 'kostum_unit';

    protected $fillable = [
        'kostum_id',
        'ukuran',
        'stok_permanen',
        'stok_aktual',
    ];

    // ── Relationships ──────────────────────────────────────────────────────

    /**
     * A KostumUnit belongs to one Kostum (parent costume).
     */
    public function kostum()
    {
        return $this->belongsTo(Kostum::class, 'kostum_id')->withTrashed();
    }

    /**
     * A KostumUnit has many DetailTransaksi (booking lines).
     */
    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'kostum_unit_id');
    }

    // ── Helpers ────────────────────────────────────────────────────────────

    /**
     * Decrement stok_aktual safely (floor at 0).
     */
    public function decrementStok(int $qty = 1): void
    {
        $this->stok_aktual = max(0, $this->stok_aktual - $qty);
        $this->save();
    }

    /**
     * Increment stok_aktual safely (cap at stok_permanen).
     */
    public function incrementStok(int $qty = 1): void
    {
        $this->stok_aktual = min($this->stok_permanen, $this->stok_aktual + $qty);
        $this->save();
    }
}
