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
        Schema::create('kostum', function (Blueprint $table) {
            $table->id();
            // Foreign key ke tabel kategori (jika kategori dihapus, kostum ikut terhapus/restrict)
            $table->foreignId('kategori_id')->constrained('kategori')->onDelete('cascade');

            $table->string('nama_kostum');
            $table->integer('stok');
            $table->integer('harga_sewa');
            $table->string('ukuran', 10); // Menyimpan S, M, L, XL
            $table->text('kelengkapan')->nullable(); // Deskripsi wig, aksesoris, dll

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kostum');
    }
};
