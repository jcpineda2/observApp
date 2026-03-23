<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_sources', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('source_type', 30); // excel, api, manual, etc
            $table->string('provider_name')->nullable();
            $table->string('system_name')->nullable();
            $table->string('base_url')->nullable();
            $table->text('description')->nullable();
            $table->json('settings')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('source_type');
            $table->index('is_active');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_sources');
    }
};
