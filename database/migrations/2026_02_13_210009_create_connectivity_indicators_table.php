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
        Schema::create('connectivity_indicators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('year_id')->constrained();
            $table->integer('operating_airports')->default(0);
            $table->integer('connected_destinations')->default(0);
            $table->integer('active_routes')->default(0);

            $table->unique(['year_id'], 'connectivity_year_unique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('connectivity_indicators');
    }
};
