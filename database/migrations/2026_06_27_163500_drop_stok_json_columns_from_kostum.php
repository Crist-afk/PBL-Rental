<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Removes the legacy stok JSON columns from the kostum table.
     * Data has already been migrated to kostum_unit in a previous migration.
     */
    public function up(): void
    {
        Schema::table('kostum', function (Blueprint $table) {
            $table->dropColumn([
                'stok_permanen',
                'stok_aktual',
                'stok_permanen_per_ukuran',
                'stok_aktual_per_ukuran',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     * Restores the legacy columns and backfills from kostum_unit.
     */
    public function down(): void
    {
        Schema::table('kostum', function (Blueprint $table) {
            $table->integer('stok_permanen')->default(0)->after('harga_sewa');
            $table->integer('stok_aktual')->default(0)->after('stok_permanen');
            $table->json('stok_permanen_per_ukuran')->nullable()->after('ukuran');
            $table->json('stok_aktual_per_ukuran')->nullable()->after('stok_permanen_per_ukuran');
        });

        // Backfill from kostum_unit
        $kostums = DB::table('kostum')->get();
        foreach ($kostums as $kostum) {
            $units = DB::table('kostum_unit')->where('kostum_id', $kostum->id)->get();

            $totalPermanen = 0;
            $totalAktual   = 0;
            $perUkuranPermanen = [];
            $perUkuranAktual   = [];

            foreach ($units as $unit) {
                $totalPermanen += $unit->stok_permanen;
                $totalAktual   += $unit->stok_aktual;
                $perUkuranPermanen[$unit->ukuran] = $unit->stok_permanen;
                $perUkuranAktual[$unit->ukuran]   = $unit->stok_aktual;
            }

            DB::table('kostum')->where('id', $kostum->id)->update([
                'stok_permanen'            => $totalPermanen,
                'stok_aktual'              => $totalAktual,
                'stok_permanen_per_ukuran' => json_encode($perUkuranPermanen),
                'stok_aktual_per_ukuran'   => json_encode($perUkuranAktual),
            ]);
        }
    }
};
