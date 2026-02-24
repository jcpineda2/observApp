<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tourism_provider_stats', function (Blueprint $table) {
            $table->id();

            $table->foreignId('year_id')->constrained()->cascadeOnDelete();
            $table->foreignId('month_id')->constrained()->cascadeOnDelete();

            $table->foreignId('service_sector_id')->constrained()->cascadeOnDelete();
            $table->foreignId('state_id')->constrained()->cascadeOnDelete(); // departamento

            $table->unsignedInteger('total_registered')->default(0);
            $table->unsignedInteger('registrations')->default(0);
            $table->unsignedInteger('cancellations')->default(0);
            $table->unsignedInteger('formalized_total')->default(0);

            $table->timestamps();

            // Evita duplicados por período + rubro + departamento (clave para carga manual)
            $table->unique(['year_id', 'month_id', 'service_sector_id', 'state_id'], 'tps_unique_period_sector_state');

            // Índices útiles para dashboards
            $table->index(['year_id', 'month_id'], 'tps_period_idx');
            $table->index(['service_sector_id', 'state_id'], 'tps_sector_state_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tourism_provider_stats');
    }
};
