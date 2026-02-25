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
        Schema::create('accommodations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accommodation_category_id')->constrained();
            $table->foreignId('state_id')->constrained();
            $table->integer('establishments_count')->default(0);
            $table->integer('rooms_count')->default(0);
            $table->integer('beds_count')->default(0);
            $table->timestamps();

            $table->unique(
                ['accommodation_category_id', 'state_id'],
                'accommodations_unique_category_state'
            );

            $table->index(['state_id'], 'accommodations_state_idx');
            $table->index(['accommodation_category_id'], 'accommodations_category_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accommodations');
    }
};
