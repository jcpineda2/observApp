<?php

namespace App\Livewire\PublicInterface\Charts;

use App\Models\TourismEmployment;
use App\Models\Year;
use Illuminate\Support\Str;
use Livewire\Component;

class EmploymentTrend extends Component
{
    public ?int $year = null;  // año seleccionado (para resaltar o filtrar si querés)
    public ?int $month = null; // anual: se ignora

    public string $chartId;
    public string $type = 'line';

    public array $labels = [];
    public array $datasets = [];

    protected $listeners = [
        'public-filters-updated' => 'onFiltersUpdated',
    ];

    public function mount(): void
    {
        $this->chartId = 'chart_' . Str::random(8);

        if (! $this->year) {
            $this->year = Year::query()->orderByDesc('year')->value('id');
        }

        $this->buildChart();
    }

    public function onFiltersUpdated($year, $month): void
    {
        $this->year  = $year ?: null;
        $this->month = $month ?: null; // anual
        $this->buildChart();
    }

    private function buildChart(): void
    {
        // Traemos serie histórica completa (recomendado para observatorio)
        $rows = TourismEmployment::query()
            ->leftJoin('years', 'years.id', '=', 'tourism_employments.year_id')
            ->selectRaw('years.year as y, SUM(tourism_employments.direct_employment) as direct_total, AVG(tourism_employments.national_participation) as nat_part_avg')
            ->groupBy('y')
            ->orderBy('y')
            ->get();

        $this->labels = $rows->pluck('y')->map(fn ($v) => (string) $v)->toArray();

        $direct = $rows->pluck('direct_total')->map(fn ($v) => (int) $v)->toArray();
        $part   = $rows->pluck('nat_part_avg')->map(fn ($v) => round((float) $v, 2))->toArray();

        // 2 datasets: empleo (izq) + participación % (der)
        $this->datasets = [
            [
                'label' => 'Empleo directo',
                'data' => $direct,
                'borderWidth' => 2,
                'tension' => 0.3,
                'yAxisID' => 'y',
            ],
            [
                'label' => 'Participación en empleo nacional (%)',
                'data' => $part,
                'borderWidth' => 2,
                'tension' => 0.3,
                'borderDash' => [6, 4],
                'yAxisID' => 'y1',
            ],
        ];

        $this->dispatchUpdate();
    }

    private function chartConfig(): array
    {
        return [
            'type' => $this->type,
            'data' => [
                'labels' => $this->labels,
                'datasets' => $this->datasets,
            ],
            'options' => [
                'responsive' => true,
                'maintainAspectRatio' => false,
                'animation' => false,
                'plugins' => [
                    'legend' => ['position' => 'bottom'],
                ],
                'scales' => [
                    'y' => [
                        'beginAtZero' => true,
                        'title' => ['display' => true, 'text' => 'Empleo (personas)'],
                    ],
                    'y1' => [
                        'beginAtZero' => true,
                        'position' => 'right',
                        'grid' => ['drawOnChartArea' => false],
                        'title' => ['display' => true, 'text' => 'Participación (%)'],
                        'min' => 0,
                        'max' => 100,
                    ],
                    'x' => [
                        'grid' => ['display' => false],
                    ],
                ],
            ],
        ];
    }

    private function dispatchUpdate(): void
    {
        $this->dispatch('observatorio:chart:update', chartId: $this->chartId, config: $this->chartConfig());
    }

    public function render()
    {
        return view('livewire.public-interface.charts.employment-trend');
    }
}
