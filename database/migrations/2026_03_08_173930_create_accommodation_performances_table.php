<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\AccommodationSeason;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accommodation_performances', function (Blueprint $table) {
            $table->id();

            $table->foreignId('year_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('month_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('state_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal('occupancy_rate', 5, 2)->default(0);

            $table->string('season', 10);

            $table->timestamps();

            $table->index(['year_id', 'month_id']);
            $table->index('state_id');
            $table->index('season');

            $table->unique(
                ['year_id', 'month_id', 'state_id'],
                'accommodation_performances_year_month_state_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accommodation_performances');
    }
};
