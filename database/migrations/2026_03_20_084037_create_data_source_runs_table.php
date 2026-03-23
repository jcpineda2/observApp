<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_source_runs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('data_source_id')
                ->constrained('data_sources')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('triggered_by_user_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('report_period_id')
                ->nullable()
                ->constrained('report_periods')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('run_type', 30);
            $table->string('status', 20)->default('pending');

            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();

            $table->unsignedInteger('records_read')->default(0);
            $table->unsignedInteger('records_inserted')->default(0);
            $table->unsignedInteger('records_updated')->default(0);
            $table->unsignedInteger('records_failed')->default(0);

            $table->text('error_summary')->nullable();
            $table->text('notes')->nullable();
            $table->json('meta')->nullable();

            $table->timestamps();

            $table->index('run_type');
            $table->index('status');
            $table->index(['data_source_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_source_runs');
    }
};
