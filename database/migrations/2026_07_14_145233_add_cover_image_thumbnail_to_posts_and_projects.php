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
        Schema::table('posts', function (Blueprint $table): void {
            $table->string('cover_image_thumbnail')->nullable()->after('cover_image');
        });

        Schema::table('projects', function (Blueprint $table): void {
            $table->string('cover_image_thumbnail')->nullable()->after('cover_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table): void {
            $table->dropColumn('cover_image_thumbnail');
        });

        Schema::table('projects', function (Blueprint $table): void {
            $table->dropColumn('cover_image_thumbnail');
        });
    }
};
