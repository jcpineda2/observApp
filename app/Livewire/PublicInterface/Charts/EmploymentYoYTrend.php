<?php

namespace App\Livewire\PublicInterface\Charts;

use App\Models\TourismEmployment;
use App\Models\Year;
use Illuminate\Support\Str;
use Livewire\Component;

class EmploymentYoYTrend extends Component
{
    public ?int $year = null;   // año seleccionado (opcional)
    public ?int $month = null;  // anual: ignorado

    public string $chartId;
    public string $type = 'line';

    public array $labels = [];
    public array $datasets = [];

    public float $latestYoY = 0.0;
    public ?string $latestYearLabel = null;

    protected $listeners = [
        'public-filters-updated' => 'onFiltersUpdated',
    ];

    public function mount(): void
    {
        $this->chartId = 'chart_' . Str::random(8);

        if (! $this->year) {
            $this->year = Year::query()->orderByDesc('year')->value('id');
        }

        $this->build();
    }

    public function onFiltersUpdated($year, $month): void
    {
        $this->year = $year ?: null;
        $this->month = $month ?: null; // anual

        $this->build();
    }

    private function build(): void
    {
        // Serie histórica YoY% (promedio por año, porque puede haber varios service_sector_id)
        $rows = TourismEmployment::query()
            ->leftJoin('years', 'years.id', '=', 'tourism_employments.year_id')
            ->selectRaw('years.year as y, AVG(tourism_employments.interannual_variation) as yoy_avg')
            ->groupBy('y')
            ->orderBy('y')
            ->get();

        $this->labels = $rows->pluck('y')->map(fn ($v) => (string) $v)->toArray();

        $yoyData = $rows->pluck('yoy_avg')->map(fn ($v) => round((float) $v, 2))->toArray();

        $this->datasets = [[
            'label' => 'Variación interanual (YoY %)',
            'data' => $yoyData,
            'borderWidth' => 2,
            'tension' => 0.3,
        ]];

        // KPI del último año disponible
        $last = $rows->last();
        $this->latestYearLabel = $last?->y ? (string) $last->y : null;
        $this->latestYoY = $last?->yoy_avg ? round((float) $last->yoy_avg, 2) : 0.0;

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
                    'x' => ['grid' => ['display' => false]],
                    'y' => [
                        'beginAtZero' => false,
                        // Podés dejarlo libre, o forzar rango si querés:
                        // 'min' => -50,
                        // 'max' => 50,
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
        return view('livewire.public-interface.charts.employment-yo-y-trend');
    }
}
