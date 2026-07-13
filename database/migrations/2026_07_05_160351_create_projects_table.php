<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Case studies / work. `featured` controls the Home page preview,
     * `display_order` the listing order. Tech stack is a simple JSON tag list
     * (KISS — no separate tags table needed at v1 content volume).
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('tagline');
            $table->text('challenge');
            $table->text('build');
            $table->text('impact');
            $table->json('tech_stack'); // array of tech tags, e.g. ["Laravel","MySQL"]
            $table->string('cover_image')->nullable();
            $table->string('cover_image_alt')->nullable();
            $table->string('live_url')->nullable();
            $table->string('repo_url')->nullable();
            $table->boolean('featured')->default(false);
            $table->unsignedInteger('display_order')->default(0);
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('og_image')->nullable();
            $table->timestamps();

            $table->index('featured');
            $table->index('display_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
