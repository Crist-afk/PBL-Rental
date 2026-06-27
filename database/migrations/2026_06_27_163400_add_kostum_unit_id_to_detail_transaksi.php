<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds kostum_unit_id to detail_transaksi so each booking row
     * references a specific costume-size unit.
     */
    public function up(): void
    {
        Schema::table('detail_transaksi', function (Blueprint $table) {
            $table->foreignId('kostum_unit_id')
                  ->nullable()
                  ->after('kostum_id')
                  ->constrained('kostum_unit')
                  ->onDelete('set null');
        });

        // ── Data Migration: fill kostum_unit_id for existing detail_transaksi rows ──
        $details = DB::table('detail_transaksi')
            ->whereNull('kostum_unit_id')
            ->get();

        foreach ($details as $detail) {
            if (!$detail->ukuran) continue;

            $unit = DB::table('kostum_unit')
                ->where('kostum_id', $detail->kostum_id)
                ->where('ukuran', $detail->ukuran)
                ->first();

            if ($unit) {
                DB::table('detail_transaksi')
                    ->where('id', $detail->id)
                    ->update(['kostum_unit_id' => $unit->id]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_transaksi', function (Blueprint $table) {
            $table->dropForeign(['kostum_unit_id']);
            $table->dropColumn('kostum_unit_id');
        });
    }
};
