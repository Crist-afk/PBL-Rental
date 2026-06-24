<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kostum extends Model
{
    protected $table = 'kostum';

    protected $fillable = [
        'kategori_id',
        'nama_kostum',
        'stok_permanen',
        'stok_aktual',
        'stok_permanen_per_ukuran',
        'stok_aktual_per_ukuran',
        'harga_sewa',
        'ukuran',
        'kelengkapan',
        'gambar'
    ];

    protected $casts = [
        'stok_permanen_per_ukuran' => 'array',
        'stok_aktual_per_ukuran' => 'array',
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
    // CALENDAR AVAILABILITY — Dihitung Dinamis dari Overlap Booking Aktif
    // Kapasitas diambil dari stok_permanen_per_ukuran (tidak membaca stok_aktual).
    // =========================================================================

    /**
     * Status transaksi yang mengunci slot kalender.
     * Batal, Ditolak, dan Selesai TIDAK memblokir slot.
     */
    public static function statusAktif(): array
    {
        return ['Menunggu Pembayaran', 'Menunggu Verifikasi', 'Sudah Dibayar', 'Disewa'];
    }

    /**
     * Hitung ketersediaan untuk ukuran tertentu pada rentang tanggal tertentu.
     *
     * Logika:
     *   kapasitas = stok_permanen_per_ukuran[$size]  (kapasitas fisik kostum)
     *   booking_overlap = detail_transaksi dengan status aktif yang tanggalnya
     *                     tumpang tindih dengan rentang yang diminta
     *   availability = max(0, kapasitas - booking_overlap)
     *
     * Overlap condition:
     *   tanggal_mulai (existing) <= tanggalSelesai (requested)
     *   AND tanggal_selesai (existing) >= tanggalMulai (requested)
     *
     * @param  string      $size           Ukuran kostum (e.g. "M")
     * @param  string|null $tanggalMulai   Format Y-m-d. Null = default ke hari ini.
     * @param  string|null $tanggalSelesai Format Y-m-d. Null = default ke hari ini.
     * @return int Ketersediaan (≥ 0)
     */
    public function getStokAktualBySize(string $size, ?string $tanggalMulai = null, ?string $tanggalSelesai = null): int
    {
        // Default: gunakan hari ini jika tanggal tidak diberikan
        $start = $tanggalMulai  ?? now()->toDateString();
        $end   = $tanggalSelesai ?? now()->toDateString();

        // Baca kapasitas dari stok_permanen_per_ukuran (BUKAN stok_aktual)
        $kapasitasPerUkuran = $this->stok_permanen_per_ukuran ?? [];
        $kapasitas = (is_array($kapasitasPerUkuran) && isset($kapasitasPerUkuran[$size]))
            ? (int) $kapasitasPerUkuran[$size]
            : 0;

        if ($kapasitas <= 0) {
            return 0;
        }

        // Hitung booking aktif yang overlap dengan rentang tanggal yang diminta
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
     * Hitung ketersediaan total kostum ini (semua ukuran) pada rentang tanggal tertentu.
     *
     * Menjumlahkan hasil getStokAktualBySize() untuk setiap ukuran yang tersedia.
     * Tidak membaca kolom stok_aktual dari database.
     *
     * @param  string|null $tanggalMulai   Format Y-m-d. Null = default ke hari ini.
     * @param  string|null $tanggalSelesai Format Y-m-d. Null = default ke hari ini.
     * @return int Ketersediaan total (≥ 0)
     */
    public function getStokAktualTotal(?string $tanggalMulai = null, ?string $tanggalSelesai = null): int
    {
        $start = $tanggalMulai  ?? now()->toDateString();
        $end   = $tanggalSelesai ?? now()->toDateString();

        $kapasitasPerUkuran = $this->stok_permanen_per_ukuran ?? [];

        if (empty($kapasitasPerUkuran) || !is_array($kapasitasPerUkuran)) {
            return 0;
        }

        $total = 0;
        foreach (array_keys($kapasitasPerUkuran) as $size) {
            $total += $this->getStokAktualBySize($size, $start, $end);
        }

        return $total;
    }

    /**
     * [DEPRECATED — PR-2 Calendar Availability]
     * Metode ini tidak lagi menulis ke database.
     * Ketersediaan dihitung dinamis dari overlap kalender; tidak ada kolom stok yang diubah.
     * Dipertahankan agar tidak merusak pemanggil yang belum di-cleanup (PR-1).
     *
     * @deprecated Gunakan getStokAktualBySize() untuk mengecek ketersediaan.
     */
    public function decrementStokAktual(string $size, int $qty = 1): void
    {
        // NO-OP: Calendar availability tidak memerlukan decrement stok fisik.
        // Ketersediaan dihitung otomatis dari status transaksi aktif.
    }

    /**
     * [DEPRECATED — PR-2 Calendar Availability]
     * Metode ini tidak lagi menulis ke database.
     * Ketersediaan dihitung dinamis dari overlap kalender; tidak ada kolom stok yang diubah.
     * Dipertahankan agar tidak merusak pemanggil yang belum di-cleanup (PR-1).
     *
     * @deprecated Tidak perlu increment; slot terbuka otomatis saat status berubah ke Batal/Selesai/Ditolak.
     */
    public function incrementStokAktual(string $size, int $qty = 1): void
    {
        // NO-OP: Calendar availability tidak memerlukan increment stok fisik.
        // Slot kalender terbuka otomatis ketika status transaksi berubah ke Batal/Selesai/Ditolak.
    }
}
