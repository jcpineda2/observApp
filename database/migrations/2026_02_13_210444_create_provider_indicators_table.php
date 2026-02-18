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
        Schema::create('provider_indicators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('year_id')->constrained();
            $table->integer('total_providers')->default(0);
            $table->integer('new_registrations')->default(0); // Altas
            $table->integer('cancellations')->default(0); // Bajas
            $table->decimal('formalization_rate', 5, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_indicators');
    }
};
