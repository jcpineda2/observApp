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
            $table->foreignId('year_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('start_month_id')->nullable()->constrained('months')->nullOnDelete();
            $table->foreignId('end_month_id')->nullable()->constrained('months')->nullOnDelete();
            $table->string('string');
            $table->boolean('is_full_year')->default(false);
            $table->timestamps();

            $table->unique(['year_id', 'start_month_id', 'end_month_id'], 'uidx_report_period_combination');
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
