<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inbound_tourisms', function (Blueprint $table) {
            $table->id();

            $table->foreignId('year_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('month_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('residence_country_id')
                ->constrained('countries')
                ->cascadeOnDelete();

            $table->foreignId('destination_department_id')
                ->constrained('states')
                ->cascadeOnDelete();

            $table->foreignId('entry_mode_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('travel_reason_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedInteger('tourist_arrivals')->default(0);
            $table->unsignedInteger('excursionist_arrivals')->default(0);
            $table->decimal('foreign_exchange_revenue', 15, 2)->default(0);
            $table->decimal('average_spend', 10, 2)->default(0);
            $table->decimal('average_stay', 8, 2)->default(0);

            $table->timestamps();

            $table->index(['year_id', 'month_id']);
            $table->index('residence_country_id');
            $table->index('destination_department_id');
            $table->index('entry_mode_id');
            $table->index('travel_reason_id');

            $table->unique(
                [
                    'year_id',
                    'month_id',
                    'residence_country_id',
                    'destination_department_id',
                    'entry_mode_id',
                    'travel_reason_id',
                ],
                'inbound_tourisms_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inbound_tourisms');
    }
};
