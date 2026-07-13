<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * YouTube video embeds. We store only the video ID — thumbnails are pulled
     * from YouTube at render time, and no files are self-hosted (requirements 5.4).
     */
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();
            $table->string('title');
            $table->string('youtube_video_id');
            $table->text('description')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index('published_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
