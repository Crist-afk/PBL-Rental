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
        'stok_per_ukuran',
        'harga_sewa',
        'ukuran',
        'kelengkapan',
        'gambar'
    ];

    protected $casts = [
        'stok_per_ukuran' => 'array',
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

        return asset('storage/' . $this->gambar);
    }

    // Relasi: Satu kostum bisa memiliki banyak gambar tambahan
    public function images()
    {
        return $this->hasMany(KostumImage::class, 'kostum_id');
    }

    // =========================================================================
    // STOK AKTUAL — Dihitung Dinamis (Stok Permanen − Booking Aktif yang Overlap)
    // =========================================================================

    /**
     * Status transaksi yang dianggap "sedang memakai" slot stok.
     * Transaksi Batal, Selesai, dan Ditolak tidak memblokir stok.
     */
    public static function statusAktif(): array
    {
        return ['Menunggu Pembayaran', 'Menunggu Verifikasi', 'Sudah Dibayar', 'Disewa'];
    }

    /**
     * Hitung stok aktual untuk ukuran tertentu pada rentang tanggal tertentu.
     *
     * @param  string      $size          Ukuran kostum (e.g. "M")
     * @param  string|null $tanggalMulai  Format Y-m-d. Null = abaikan filter tanggal.
     * @param  string|null $tanggalSelesai Format Y-m-d. Null = abaikan filter tanggal.
     * @return int Stok aktual (≥ 0)
     */
    public function getStokAktualBySize(string $size, ?string $tanggalMulai = null, ?string $tanggalSelesai = null): int
    {
        // Stok permanen per ukuran
        $stokPerUkuran = $this->stok_per_ukuran ?? [];
        $stokPermanen = (is_array($stokPerUkuran) && isset($stokPerUkuran[$size]))
            ? (int) $stokPerUkuran[$size]
            : (int) $this->stok;

        // Hitung jumlah booking aktif yang overlap tanggal
        $query = DetailTransaksi::where('kostum_id', $this->id)
            ->where('ukuran', $size)
            ->whereHas('transaksi', function ($q) use ($tanggalMulai, $tanggalSelesai) {
                $q->whereIn('status', self::statusAktif());
                if ($tanggalMulai && $tanggalSelesai) {
                    $q->where('tanggal_mulai', '<=', $tanggalSelesai)
                      ->where('tanggal_selesai', '>=', $tanggalMulai);
                }
            });

        $bookedCount = $query->count();

        return max(0, $stokPermanen - $bookedCount);
    }

    /**
     * Hitung stok aktual total (semua ukuran) pada rentang tanggal tertentu.
     *
     * @param  string|null $tanggalMulai   Format Y-m-d. Null = abaikan filter tanggal.
     * @param  string|null $tanggalSelesai Format Y-m-d. Null = abaikan filter tanggal.
     * @return int Stok aktual total (≥ 0)
     */
    public function getStokAktualTotal(?string $tanggalMulai = null, ?string $tanggalSelesai = null): int
    {
        $stokPermanen = (int) $this->stok;

        $query = DetailTransaksi::where('kostum_id', $this->id)
            ->whereHas('transaksi', function ($q) use ($tanggalMulai, $tanggalSelesai) {
                $q->whereIn('status', self::statusAktif());
                if ($tanggalMulai && $tanggalSelesai) {
                    $q->where('tanggal_mulai', '<=', $tanggalSelesai)
                      ->where('tanggal_selesai', '>=', $tanggalMulai);
                }
            });

        $bookedCount = $query->count();

        return max(0, $stokPermanen - $bookedCount);
    }
}
