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
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->unique()->constrained('transaksi')->onDelete('cascade');
            $table->date('tanggal_kembali_aktual');
            $table->enum('kondisi_barang', ['Baik', 'Lecet', 'Rusak']);
            $table->text('catatan_qc')->nullable();
            $table->integer('denda_keterlambatan')->default(0);
            $table->integer('denda_kerusakan')->default(0);
            $table->integer('total_denda')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalian');
    }
};
