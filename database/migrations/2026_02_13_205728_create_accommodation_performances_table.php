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
        Schema::create('accommodation_performances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accommodation_id')->constrained();
            $table->foreignId('year_id')->constrained();
            $table->foreignId('month_id')->constrained();

            $table->decimal('occupancy_rate', 5, 2); // Porcentaje
            $table->string('season')->nullable(); // Temporada

            $table->unique(
                ['accommodation_id', 'year_id', 'month_id'],
                'acc_perf_unique'
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accommodation_performances');
    }
};
