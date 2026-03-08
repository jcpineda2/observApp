<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accommodation_capacities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('accommodation_category_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('state_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedInteger('establishments_count')->default(0);
            $table->unsignedInteger('rooms_count')->default(0);
            $table->unsignedInteger('beds_count')->default(0);

            $table->timestamps();

            $table->unique(
                ['accommodation_category_id', 'state_id'],
                'accommodation_capacities_category_state_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accommodation_capacities');
    }
};
