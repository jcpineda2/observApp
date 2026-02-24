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
        Schema::create('inbound_tourisms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('year_id')->constrained();
            $table->foreignId('month_id')->constrained();
            $table->foreignId('residence_country_id')->constrained('countries');
            $table->foreignId('entry_mode_id')->constrained();
            $table->foreignId('travel_reason_id')->constrained();

            $table->integer('tourist_arrivals')->default(0);
            $table->integer('excursionist_arrivals')->default(0);
            $table->decimal('foreign_exchange_revenue', 15, 2)->default(0); // Divisas
            $table->decimal('average_spend', 10, 2)->default(0);
            $table->decimal('average_stay', 8, 2)->default(0); // Estadia

            $table->unique([
                'year_id',
                'month_id',
                'residence_country_id',
                'entry_mode_id',
                'travel_reason_id'
            ], 'inbound_unique_combo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inbound_tourisms');
    }
};
