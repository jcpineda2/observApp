<?php

namespace App\Filament\Widgets;

use App\Models\TourismProviderStat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TourismProviderStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Tomamos "último período cargado" (año/mes máximo)
        $latest = TourismProviderStat::query()
            ->select('year_id', 'month_id')
            ->distinct()
            ->orderByDesc('year_id')
            ->orderByDesc('month_id')
            ->first();

        if (! $latest) {
            return [
                Stat::make('Sin datos', 'Cargá registros en Prestadores (mensual)')->description('No hay estadísticas todavía.'),
            ];
        }

        $baseQuery = TourismProviderStat::query()
            ->where('year_id', $latest->year_id)
            ->where('month_id', $latest->month_id);

        $total = (int) $baseQuery->sum('total_registered');
        $altas = (int) $baseQuery->sum('registrations');
        $bajas = (int) $baseQuery->sum('cancellations');
        $formalizados = (int) $baseQuery->sum('formalized_total');

        $formalizacionPct = $total > 0 ? round(($formalizados / $total) * 100, 2) : 0;

        // Variación interanual: mismo mes, año anterior
        $prevYearTotal = (int) TourismProviderStat::query()
            ->where('year_id', $latest->year_id - 1)
            ->where('month_id', $latest->month_id)
            ->sum('total_registered');

        $yoy = $prevYearTotal > 0 ? round((($total - $prevYearTotal) / $prevYearTotal) * 100, 2) : null;

        return [
            Stat::make('Total nacional (mes)', number_format($total, 0, ',', '.'))
                ->description("Año {$latest->year_id} - Mes {$latest->month_id}")
                ->descriptionIcon('heroicon-m-calendar'),

            Stat::make('Altas (mes)', number_format($altas, 0, ',', '.'))
                ->description('Altas del período')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),

            Stat::make('Bajas (mes)', number_format($bajas, 0, ',', '.'))
                ->description('Bajas del período')
                ->descriptionIcon('heroicon-m-arrow-trending-down'),

            Stat::make('% Formalización', $formalizacionPct . '%')
                ->description('Formalizados / Total')
                ->descriptionIcon('heroicon-m-check-badge'),

            Stat::make('Variación interanual', $yoy === null ? '—' : ($yoy . '%'))
                ->description('Vs mismo mes año anterior')
                ->descriptionIcon('heroicon-m-arrows-right-left'),
        ];
    }
}
