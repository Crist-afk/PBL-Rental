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
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id();
            // Foreign key ke transaksi (Jika nota dibatalkan/dihapus, detailnya ikut hilang)
            $table->foreignId('transaksi_id')->constrained('transaksi')->onDelete('cascade');

            // Foreign key ke kostum (Mencegah kostum dihapus jika sedang ada di riwayat transaksi aktif)
            $table->foreignId('kostum_id')->constrained('kostum')->onDelete('restrict');

            // Atribut pengunci harga
            $table->integer('harga_sewa_saat_transaksi');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
    }
};
