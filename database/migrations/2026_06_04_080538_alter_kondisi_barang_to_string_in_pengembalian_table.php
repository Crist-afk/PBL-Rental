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
        // Ubah dari ENUM terbatas ke VARCHAR agar admin bisa mengetik kondisi kostum bebas
        \Illuminate\Support\Facades\DB::statement(
            "ALTER TABLE pengembalian MODIFY COLUMN kondisi_barang VARCHAR(255) NOT NULL DEFAULT 'Baik'"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback: kembalikan ke ENUM (data yang tidak sesuai enum akan menjadi '' jika ada)
        \Illuminate\Support\Facades\DB::statement(
            "ALTER TABLE pengembalian MODIFY COLUMN kondisi_barang ENUM('Baik','Lecet','Rusak') NOT NULL DEFAULT 'Baik'"
        );
    }
};
