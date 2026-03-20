<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inbound_arrivals_by_entry_point', function (Blueprint $table) {
            $table->id();

            $table->foreignId('report_period_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('entry_point_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedInteger('tourist_arrivals')->default(0);

            $table->foreignId('data_source_run_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->text('source_note')->nullable();

            $table->timestamps();

            $table->unique(
                ['report_period_id', 'entry_point_id'],
                'inbound_arrivals_by_entry_point_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inbound_arrivals_by_entry_point');
    }
};
