<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Client testimonials. Nothing goes live until manually approved
     * (requirements 5.3) — hence the status column defaulting to pending.
     */
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $table->string('client_name');
            $table->string('role')->nullable();
            $table->string('company')->nullable();
            $table->text('quote');
            $table->string('avatar')->nullable();
            $table->string('status')->default('pending'); // App\Enums\TestimonialStatus
            $table->timestamps();

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
