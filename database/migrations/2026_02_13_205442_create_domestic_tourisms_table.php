<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('domestic_tourisms', function (Blueprint $table) {
            $table->id();

            $table->foreignId('year_id')->constrained()->cascadeOnDelete();
            $table->foreignId('month_id')->nullable()->constrained()->nullOnDelete();

            $table->foreignId('destination_department_id')
                ->nullable()
                ->constrained('states')
                ->nullOnDelete();

            $table->foreignId('origin_region_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('travel_reason_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->unsignedInteger('tourist_quantity')->default(0);
            $table->decimal('total_spend', 15, 2)->default(0);
            $table->decimal('average_stay', 8, 2)->default(0);

            $table->timestamps();

            $table->index(['year_id', 'month_id']);
            $table->index('destination_department_id');
            $table->index('travel_reason_id');
            $table->index('origin_region_id');

            $table->unique(
                ['year_id', 'month_id', 'destination_department_id', 'origin_region_id', 'travel_reason_id'],
                'domestic_tourisms_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('domestic_tourisms');
    }
};
