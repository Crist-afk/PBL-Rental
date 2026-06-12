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
        $columns = array_values(array_filter([
            Schema::hasColumn('transaksi', 'total_denda') ? 'total_denda' : null,
            Schema::hasColumn('transaksi', 'tanggal_kembali_aktual') ? 'tanggal_kembali_aktual' : null,
            Schema::hasColumn('transaksi', 'kondisi_kostum') ? 'kondisi_kostum' : null,
        ]));

        if ($columns !== []) {
            Schema::table('transaksi', function (Blueprint $table) use ($columns) {
                $table->dropColumn($columns);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('transaksi', 'total_denda')) {
            Schema::table('transaksi', function (Blueprint $table) {
                $table->integer('total_denda')->default(0)->after('total_biaya');
            });
        }

        if (! Schema::hasColumn('transaksi', 'tanggal_kembali_aktual')) {
            Schema::table('transaksi', function (Blueprint $table) {
                $table->date('tanggal_kembali_aktual')->nullable()->after('catatan_admin');
            });
        }

        if (! Schema::hasColumn('transaksi', 'kondisi_kostum')) {
            Schema::table('transaksi', function (Blueprint $table) {
                $table->enum('kondisi_kostum', ['Baik', 'Lecet', 'Rusak'])->nullable()->after('tanggal_kembali_aktual');
            });
        }
    }
};
