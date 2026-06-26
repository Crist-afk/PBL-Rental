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
        Schema::table('kostum', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('forum_posts', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('forum_comments', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kostum_and_forum_tables', function (Blueprint $table) {
            //
        });
    }
};
