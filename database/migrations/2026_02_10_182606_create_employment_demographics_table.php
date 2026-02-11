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
        Schema::create('employment_demographics', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tourism_employment_id')->constrained()->onDelete('cascade');
            $table->string('gender')->index();
            $table->string('age_range');
            $table->integer('people_count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employment_demographics');
    }
};
