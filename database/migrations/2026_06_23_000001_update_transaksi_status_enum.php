<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Tambah status baru ke kolom enum transaksi:
     * - 'Menunggu Verifikasi' : pelanggan sudah upload bukti, menunggu admin
     * - 'Sudah Dibayar'       : admin sudah approve, kostum belum diambil
     *
     * Juga konversi data existing:
     * - 'Disewa' lama (artinya sudah approve) → 'Sudah Dibayar'
     *   (karena belum bisa tahu mana yang sudah diambil fisik)
     */
    public function up(): void
    {
        // MySQL: ubah definisi enum dengan menambahkan nilai baru
        // ORDER penting: enum harus lengkap di ALTER TABLE
        DB::statement("ALTER TABLE transaksi MODIFY COLUMN status ENUM(
            'Menunggu Pembayaran',
            'Menunggu Verifikasi',
            'Sudah Dibayar',
            'Disewa',
            'Selesai',
            'Batal'
        ) NOT NULL DEFAULT 'Menunggu Pembayaran'");

        // Konversi data existing:
        // Transaksi lama dengan status 'Disewa' sekarang dianggap 'Sudah Dibayar'
        // karena kita tidak bisa tahu mana yang sudah diambil fisik
        DB::statement("UPDATE transaksi SET status = 'Sudah Dibayar' WHERE status = 'Disewa'");
    }

    /**
     * Rollback: kembalikan enum ke semula dan data ke 'Disewa'
     */
    public function down(): void
    {
        // Kembalikan status 'Sudah Dibayar' dan 'Menunggu Verifikasi' ke kondisi semula
        DB::statement("UPDATE transaksi SET status = 'Menunggu Pembayaran' WHERE status = 'Menunggu Verifikasi'");
        DB::statement("UPDATE transaksi SET status = 'Disewa' WHERE status = 'Sudah Dibayar'");

        // Kembalikan enum ke definisi asal
        DB::statement("ALTER TABLE transaksi MODIFY COLUMN status ENUM(
            'Menunggu Pembayaran',
            'Disewa',
            'Selesai',
            'Batal'
        ) NOT NULL DEFAULT 'Menunggu Pembayaran'");
    }
};
