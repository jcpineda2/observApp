<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employment_demographics', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tourism_employment_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('gender', 20);

            $table->foreignId('age_range_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedInteger('people_count')->default(0);

            $table->timestamps();

            $table->unique(
                ['tourism_employment_id', 'gender', 'age_range_id'],
                'employment_demographics_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employment_demographics');
    }
};
