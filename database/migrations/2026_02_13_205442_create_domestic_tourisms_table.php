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
        Schema::create('domestic_tourisms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('year_id')->constrained();
            $table->foreignId('month_id')->constrained();
            $table->foreignId('destination_department_id')->constrained('states');
            $table->foreignId('travel_reason_id')->constrained();
            $table->string('origin_region')->nullable()->default('N/A'); //Para que el unique no tenga problemas al tener not null
            $table->integer('tourist_quantity')->default(0);
            $table->decimal('total_spend', 15, 2)->default(0);
            $table->decimal('average_stay', 8, 2)->default(0);
            $table->string('spend_composition')->nullable();

            $table->unique(
                ['year_id', 'month_id', 'destination_department_id', 'travel_reason_id', 'origin_region'],
                'domestic_unique'
            );
            $table->index(['year_id', 'month_id'], 'domestic_year_month_idx');
            $table->index('destination_department_id', 'domestic_destination_department_idx');
            $table->index('travel_reason_id', 'domestic_travel_reason_idx');
            $table->index('origin_region', 'domestic_origin_region_idx');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domestic_tourisms');
    }
};
