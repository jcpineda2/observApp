<?php

namespace App\Filament\Widgets;

use App\Models\TourismProviderStat;
use Filament\Widgets\ChartWidget;

class TourismProviderStatsTrendChart extends ChartWidget
{
    protected  ?string $heading = 'Prestadores: Altas vs Bajas (últimos 12 períodos)';

    protected function getData(): array
    {
        $periods = TourismProviderStat::query()
            ->select('year_id', 'month_id')
            ->distinct()
            ->orderByDesc('year_id')
            ->orderByDesc('month_id')
            ->limit(12)
            ->get()
            ->reverse()
            ->values();

        if ($periods->isEmpty()) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        $labels = [];
        $altas = [];
        $bajas = [];

        foreach ($periods as $p) {
            $labels[] = "{$p->year_id}-" . str_pad((string) $p->month_id, 2, '0', STR_PAD_LEFT);

            $q = TourismProviderStat::query()
                ->where('year_id', $p->year_id)
                ->where('month_id', $p->month_id);

            $altas[] = (int) $q->sum('registrations');
            $bajas[] = (int) $q->sum('cancellations');
        }

        return [
            'datasets' => [
                ['label' => 'Altas', 'data' => $altas],
                ['label' => 'Bajas', 'data' => $bajas],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
