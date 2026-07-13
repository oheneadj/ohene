<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Contact-form submissions. UTM/referrer fields capture lead source so we
     * can measure what's actually generating inquiries (requirements MR2).
     */
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();
            $table->string('name');
            $table->string('email');
            $table->text('message');
            $table->string('project_type')->nullable(); // App\Enums\ProjectType
            $table->string('budget_range')->nullable(); // App\Enums\BudgetRange
            $table->string('utm_source')->nullable();
            $table->string('utm_medium')->nullable();
            $table->string('utm_campaign')->nullable();
            $table->string('referrer')->nullable();
            $table->string('status')->default('new'); // App\Enums\LeadStatus
            $table->timestamps();

            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
