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
        Schema::create('report_periods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('year_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('start_month_id')->nullable()->constrained('months')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('end_month_id')->nullable()->constrained('months')->cascadeOnUpdate()->restrictOnDelete();

            $table->string('period_type', 20);
            $table->string('period_key')->unique();
            $table->string('label');
            $table->boolean('is_full_year')->default(false);
            $table->date('starts_at')->nullable();
            $table->date('ends_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('period_type');
            $table->index(['year_id', 'start_month_id', 'end_month_id']);
            $table->unique(['year_id', 'start_month_id', 'end_month_id'], 'report_periods_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_periods');
    }
};
