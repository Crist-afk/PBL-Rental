<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Tambah status 'Ditolak' ke enum transaksi.
     * Digunakan ketika admin menolak bukti pembayaran pelanggan.
     * Berbeda dengan 'Batal' (dibatalkan admin/pelanggan) dan
     * 'Menunggu Pembayaran' (kembali ke awal).
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE transaksi MODIFY COLUMN status ENUM(
            'Menunggu Pembayaran',
            'Menunggu Verifikasi',
            'Ditolak',
            'Sudah Dibayar',
            'Disewa',
            'Selesai',
            'Batal'
        ) NOT NULL DEFAULT 'Menunggu Pembayaran'");
    }

    /**
     * Rollback: kembalikan 'Ditolak' ke 'Menunggu Pembayaran', lalu hapus nilai enum.
     */
    public function down(): void
    {
        // Kembalikan semua transaksi Ditolak ke Menunggu Pembayaran sebelum hapus enum
        DB::statement("UPDATE transaksi SET status = 'Menunggu Pembayaran' WHERE status = 'Ditolak'");

        DB::statement("ALTER TABLE transaksi MODIFY COLUMN status ENUM(
            'Menunggu Pembayaran',
            'Menunggu Verifikasi',
            'Sudah Dibayar',
            'Disewa',
            'Selesai',
            'Batal'
        ) NOT NULL DEFAULT 'Menunggu Pembayaran'");
    }
};
