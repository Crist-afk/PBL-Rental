<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates the kostum_unit table: each row = one costume+size combination
     * with its own stok_permanen and stok_aktual.
     */
    public function up(): void
    {
        Schema::create('kostum_unit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kostum_id')
                  ->constrained('kostum')
                  ->onDelete('cascade');
            $table->string('ukuran', 20); // e.g. "S", "M", "L", "XL", "XXL"
            $table->integer('stok_permanen')->default(0); // physical capacity for this size
            $table->integer('stok_aktual')->default(0);   // remaining available stock
            $table->timestamps();

            // A costume can only have one row per size
            $table->unique(['kostum_id', 'ukuran']);
        });

        // ── Data Migration: transfer JSON stok data → kostum_unit rows ──
        $kostums = DB::table('kostum')->get();

        foreach ($kostums as $kostum) {
            $stokPermanen = json_decode($kostum->stok_permanen_per_ukuran ?? '{}', true) ?: [];
            $stokAktual   = json_decode($kostum->stok_aktual_per_ukuran   ?? '{}', true) ?: [];

            if (empty($stokPermanen)) {
                // Fallback: if no JSON data, read from ukuran string and use total stok
                $sizes = $kostum->ukuran
                    ? array_filter(array_map('trim', explode(',', $kostum->ukuran)))
                    : [];

                foreach ($sizes as $size) {
                    if ($size === '') continue;
                    DB::table('kostum_unit')->insert([
                        'kostum_id'      => $kostum->id,
                        'ukuran'         => $size,
                        'stok_permanen'  => 0,
                        'stok_aktual'    => 0,
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ]);
                }
            } else {
                foreach ($stokPermanen as $size => $qty) {
                    $size = trim((string) $size);
                    if ($size === '') continue;

                    DB::table('kostum_unit')->insert([
                        'kostum_id'      => $kostum->id,
                        'ukuran'         => $size,
                        'stok_permanen'  => (int) $qty,
                        'stok_aktual'    => (int) ($stokAktual[$size] ?? $qty),
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kostum_unit');
    }
};
