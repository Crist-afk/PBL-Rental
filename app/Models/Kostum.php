<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kostum extends Model
{
    use SoftDeletes;

    protected $table = 'kostum';

    protected $fillable = [
        'kategori_id',
        'nama_kostum',
        'harga_sewa',
        'ukuran',       // denormalised comma-separated string: "L, XL, XXL"
        'kelengkapan',
        'gambar',
    ];

    // ── Relationships ──────────────────────────────────────────────────────

    /** One costume belongs to one category. */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    /** One costume has many booking detail lines. */
    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'kostum_id');
    }

    /** One costume has many size-unit rows (kostum_unit). */
    public function units()
    {
        return $this->hasMany(KostumUnit::class, 'kostum_id');
    }

    /** One costume has many extra gallery images. */
    public function images()
    {
        return $this->hasMany(KostumImage::class, 'kostum_id');
    }

    // ── Accessors ──────────────────────────────────────────────────────────

    /**
     * Returns a valid image URL (external link or local storage).
     */
    public function getGambarUrlAttribute()
    {
        if (!$this->gambar) {
            return 'https://via.placeholder.com/400x500.png?text=No+Image';
        }
        if (filter_var($this->gambar, FILTER_VALIDATE_URL)) {
            return $this->gambar;
        }
        return asset('storage/' . $this->gambar);
    }

    // ── Stock Helpers ──────────────────────────────────────────────────────

    /**
     * Status values that occupy a calendar slot / lock stock.
     * Cancelled, Rejected, and Completed statuses do NOT block availability.
     */
    public static function statusAktif(): array
    {
        return ['Menunggu Pembayaran', 'Menunggu Verifikasi', 'Sudah Dibayar', 'Disewa'];
    }

    /**
     * Get the KostumUnit row for a specific size (or null if not found).
     */
    public function getUnit(string $size): ?KostumUnit
    {
        return $this->units->firstWhere('ukuran', trim($size));
    }

    /**
     * Returns stok_aktual for a given size from the kostum_unit table.
     *
     * If $tanggalMulai / $tanggalSelesai are provided, availability is
     * computed dynamically from calendar overlap — same logic as before but
     * now reads stok_permanen from kostum_unit rather than a JSON column.
     *
     * @param  string      $size
     * @param  string|null $tanggalMulai   Y-m-d  (null = today)
     * @param  string|null $tanggalSelesai Y-m-d  (null = today)
     * @return int  available stock (≥ 0)
     */
    public function getStokAktualBySize(string $size, ?string $tanggalMulai = null, ?string $tanggalSelesai = null): int
    {
        $start = $tanggalMulai  ?? now()->toDateString();
        $end   = $tanggalSelesai ?? now()->toDateString();

        // Read capacity from kostum_unit
        $unit = KostumUnit::where('kostum_id', $this->id)
            ->where('ukuran', $size)
            ->first();

        if (!$unit || $unit->stok_permanen <= 0) {
            return 0;
        }

        $kapasitas = $unit->stok_permanen;

        // Count active bookings that overlap the requested date range
        $bookedCount = DetailTransaksi::where('kostum_id', $this->id)
            ->where('ukuran', $size)
            ->whereHas('transaksi', function ($q) use ($start, $end) {
                $q->whereIn('status', self::statusAktif())
                  ->where('tanggal_mulai', '<=', $end)
                  ->where('tanggal_selesai', '>=', $start);
            })
            ->count();

        return max(0, $kapasitas - $bookedCount);
    }

    /**
     * Returns total stok_aktual across all sizes for a given date range.
     *
     * @param  string|null $tanggalMulai
     * @param  string|null $tanggalSelesai
     * @return int
     */
    public function getStokAktualTotal(?string $tanggalMulai = null, ?string $tanggalSelesai = null): int
    {
        $start = $tanggalMulai  ?? now()->toDateString();
        $end   = $tanggalSelesai ?? now()->toDateString();

        $units = KostumUnit::where('kostum_id', $this->id)->get();

        if ($units->isEmpty()) {
            return 0;
        }

        $total = 0;
        foreach ($units as $unit) {
            $total += $this->getStokAktualBySize($unit->ukuran, $start, $end);
        }

        return $total;
    }

    /**
     * Returns the total stok_permanen across all sizes (sum of kostum_unit rows).
     * This acts as an accessor for $kostum->stok_permanen
     */
    public function getStokPermanenAttribute(): int
    {
        return $this->units->sum('stok_permanen');
    }

    /**
     * Returns the total stok_aktual across all sizes (sum of kostum_unit rows).
     * This acts as an accessor for $kostum->stok_aktual
     */
    public function getStokAktualAttribute(): int
    {
        return $this->units->sum('stok_aktual');
    }

    // ── Deprecated stubs (kept for backward-compat, now no-ops) ───────────

    /** @deprecated Use getStokAktualBySize() */
    public function decrementStokAktual(string $size, int $qty = 1): void
    {
        $unit = KostumUnit::where('kostum_id', $this->id)
            ->where('ukuran', $size)
            ->first();
        $unit?->decrementStok($qty);
    }

    /** @deprecated Use getStokAktualBySize() */
    public function incrementStokAktual(string $size, int $qty = 1): void
    {
        $unit = KostumUnit::where('kostum_id', $this->id)
            ->where('ukuran', $size)
            ->first();
        $unit?->incrementStok($qty);
    }
}
