<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inbound_arrivals_by_month', function (Blueprint $table) {
            $table->id();

            $table->foreignId('year_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('month_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedInteger('tourist_arrivals')->default(0);

            $table->foreignId('data_source_run_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->text('source_note')->nullable();

            $table->timestamps();

            $table->unique(['year_id', 'month_id'], 'inbound_arrivals_by_month_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inbound_arrivals_by_month');
    }
};
