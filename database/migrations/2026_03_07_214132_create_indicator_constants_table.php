<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('indicator_constants', function (Blueprint $table) {
            $table->id();

            $table->string('domain', 40)->index();
            $table->string('key', 60)->index();

            $table->foreignId('year_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->decimal('value', 14, 4);

            $table->string('label')->nullable();
            $table->string('unit', 30)->nullable();
            $table->string('source')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->unique(['domain', 'key', 'year_id'], 'indicator_constants_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('indicator_constants');
    }
};
