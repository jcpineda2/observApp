<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('air_connectivity_routes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('year_id')->constrained()->restrictOnDelete();
            $table->foreignId('month_id')->constrained()->restrictOnDelete();

            $table->foreignId('air_line_id')->constrained('air_lines')->restrictOnDelete();

            $table->foreignId('origin_airport_id')->constrained('airports')->restrictOnDelete();
            $table->foreignId('destination_airport_id')->constrained('airports')->restrictOnDelete();

            $table->boolean('is_active')->default(true);

            $table->unsignedInteger('flights_count')->nullable();
            $table->unsignedInteger('seats_count')->nullable();

            $table->timestamps();

            // Evita duplicados por período + ruta + aerolínea
            $table->unique(
                ['year_id', 'month_id', 'air_line_id', 'origin_airport_id', 'destination_airport_id'],
                'air_connectivity_routes_unique'
            );

            // índices para dashboards
            $table->index(['year_id', 'month_id'], 'acr_period_idx');
            $table->index(['air_line_id'], 'acr_airline_idx');
            $table->index(['destination_airport_id'], 'acr_dest_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('air_connectivity_routes');
    }
};
