<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambah kolom-kolom baru untuk mendukung alur Pembayaran & Pengembalian Admin.
     */
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            // Untuk halaman Pembayaran Admin
            $table->string('bukti_pembayaran')->nullable()->after('status');
            $table->text('catatan_admin')->nullable()->after('bukti_pembayaran');

            // Untuk halaman Pengembalian Admin
            $table->date('tanggal_kembali_aktual')->nullable()->after('catatan_admin');
            $table->enum('kondisi_kostum', ['Baik', 'Lecet', 'Rusak'])->nullable()->after('tanggal_kembali_aktual');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn(['bukti_pembayaran', 'catatan_admin', 'tanggal_kembali_aktual', 'kondisi_kostum']);
        });
    }
};
