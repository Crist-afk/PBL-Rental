<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('forum_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->string('icon')->nullable();
            $table->timestamps();
        });

        $timestamp = now();

        DB::table('forum_categories')->insert([
            [
                'name' => 'Semua Diskusi',
                'slug' => 'semua-diskusi',
                'description' => 'Ruang obrolan umum untuk komunitas CosRent.',
                'icon' => 'fa-fire',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'Cari Kostum',
                'slug' => 'cari-kostum',
                'description' => 'Diskusi seputar pencarian kostum, ukuran, dan vendor.',
                'icon' => 'fa-magnifying-glass',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'Tips Cosplay',
                'slug' => 'tips-cosplay',
                'description' => 'Berbagi pengalaman styling, make up, dan perawatan kostum.',
                'icon' => 'fa-lightbulb',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'Jadwal Event',
                'slug' => 'jadwal-event',
                'description' => 'Info event, gathering, dan agenda komunitas terdekat.',
                'icon' => 'fa-calendar-star',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_categories');
    }
};
