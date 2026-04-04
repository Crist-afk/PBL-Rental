<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            // Foreign key ke tabel users (Pelanggan)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->integer('total_biaya');
            $table->integer('total_denda')->default(0); // Default 0 sebelum ada keterlambatan
            $table->enum('status', ['Menunggu Pembayaran', 'Disewa', 'Selesai', 'Batal'])->default('Menunggu Pembayaran');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
