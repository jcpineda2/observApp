<?php

namespace App\Filament\Widgets;

use App\Models\AirConnectivityRoute;
use Filament\Widgets\ChartWidget;

class AirConnectivityActiveTrendChart extends ChartWidget
{
    protected ?string $heading = 'Conectividad: Rutas activas (últimos 12 períodos)';

    protected function getData(): array
    {
        $periods = AirConnectivityRoute::query()
            ->select('year_id', 'month_id')
            ->distinct()
            ->orderByDesc('year_id')
            ->orderByDesc('month_id')
            ->limit(12)
            ->get()
            ->reverse()
            ->values();

        if ($periods->isEmpty()) {
            return ['datasets' => [], 'labels' => []];
        }

        $labels = [];
        $data = [];

        foreach ($periods as $p) {
            $labels[] = "{$p->year_id}-" . str_pad((string) $p->month_id, 2, '0', STR_PAD_LEFT);

            $data[] = (int) AirConnectivityRoute::query()
                ->where('year_id', $p->year_id)
                ->where('month_id', $p->month_id)
                ->where('is_active', true)
                ->count();
        }

        return [
            'datasets' => [
                ['label' => 'Rutas activas', 'data' => $data],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
