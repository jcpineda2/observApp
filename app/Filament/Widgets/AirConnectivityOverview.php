<?php

namespace App\Filament\Widgets;

use App\Models\AirConnectivityRoute;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AirConnectivityOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $latest = AirConnectivityRoute::query()
            ->select('year_id', 'month_id')
            ->orderByDesc('year_id')
            ->orderByDesc('month_id')
            ->first();

        if (! $latest) {
            return [
                Stat::make('Sin datos', 'Cargá rutas en Conectividad')->description('No hay estadísticas todavía.'),
            ];
        }

        $active = AirConnectivityRoute::query()
            ->where('year_id', $latest->year_id)
            ->where('month_id', $latest->month_id)
            ->where('is_active', true);

        $routesActive = (int) $active->count();

        // Aeropuertos operativos: distintos aeropuertos en rutas activas (origen + destino)
        $originIds = (clone $active)->pluck('origin_airport_id')->unique();
        $destIds   = (clone $active)->pluck('destination_airport_id')->unique();
        $airportsOperational = $originIds->merge($destIds)->unique()->count();

        // Destinos conectados: destinos únicos (aeropuerto destino)
        $destinationsConnected = $destIds->count();

        return [
            Stat::make('Aeropuertos operativos', number_format($airportsOperational, 0, ',', '.'))
                ->description("Periodo: {$latest->year_id} / {$latest->month_id}"),

            Stat::make('Destinos conectados', number_format($destinationsConnected, 0, ',', '.'))
                ->description('Aeropuertos destino únicos'),

            Stat::make('Rutas activas', number_format($routesActive, 0, ',', '.'))
                ->description('Rutas activas del período'),
        ];
    }
}
