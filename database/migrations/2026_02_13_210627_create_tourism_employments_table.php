<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tourism_employments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('year_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('service_sector_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedInteger('direct_employment')->default(0);
            $table->decimal('national_participation', 8, 2)->default(0);
            $table->decimal('interannual_variation', 8, 2)->default(0);

            $table->timestamps();

            $table->unique(
                ['year_id', 'service_sector_id'],
                'tourism_employments_year_sector_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tourism_employments');
    }
};
