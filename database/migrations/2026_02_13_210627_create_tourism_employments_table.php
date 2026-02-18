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
        Schema::create('tourism_employments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('year_id')->constrained();
            $table->foreignId('service_sector_id')->constrained();
            $table->integer('direct_employment')->default(0);
            $table->decimal('national_participation', 5, 2)->nullable();
            $table->decimal('interannual_variation', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourism_employments');
    }
};
