<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom has_seen_guide ke tabel users.
     * Digunakan untuk onboarding user baru ke halaman Panduan Rental.
     * Default false => user baru akan diarahkan ke /panduan-rental setelah register/login.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('has_seen_guide')->default(false)->after('no_hp');
        });
    }

    /**
     * Rollback: hapus kolom has_seen_guide.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('has_seen_guide');
        });
    }
};
