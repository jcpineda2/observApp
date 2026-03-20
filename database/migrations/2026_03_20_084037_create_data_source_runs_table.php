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
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('report_period_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('name');
            $table->string('source_file_name')->nullable();
            $table->string('source_file_path')->nullable();
            $table->string('source_sheet_name')->nullable();
            $table->string('external_reference')->nullable();
            $table->string('source_url')->nullable();
            $table->string('checksum')->nullable();

            $table->timestamp('extracted_at')->nullable();
            $table->timestamp('imported_at')->nullable();
            $table->timestamp('validated_at')->nullable();

            $table->foreignId('imported_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('validated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('status', 30)->default('draft');
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_source_runs');
    }
};
