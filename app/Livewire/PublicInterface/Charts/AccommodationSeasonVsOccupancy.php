<?php

namespace App\Livewire\PublicInterface\Charts;

use App\Models\AccommodationPerformance;
use App\Models\Year;
use Illuminate\Support\Str;
use Livewire\Component;

class AccommodationSeasonVsOccupancy extends Component
{
    public ?int $year = null;
    public ?int $month = null;

    public string $chartId;
    public string $type = 'doughnut';

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
        $this->month = $month ?: null;

        $this->buildChart();
    }

    private function buildChart(): void
    {
        if (! $this->year) {
            $this->labels = [];
            $this->datasets = [];
            $this->dispatchUpdate();
            return;
        }

        // AVG ocupación por temporada en el período
        $rows = AccommodationPerformance::query()
            ->where('year_id', $this->year)
            ->when($this->month, fn ($q) => $q->where('month_id', $this->month))
            ->selectRaw('season, AVG(occupancy_rate) as avg_occ')
            ->groupBy('season')
            ->orderBy('season')
            ->get();

        $labels = $rows->pluck('season')->map(fn ($v) => $v ?? 'Sin temporada')->toArray();
        $data   = $rows->pluck('avg_occ')->map(fn ($v) => round((float) $v, 2))->toArray();

        $this->labels = $labels;

        $this->datasets = [[
            'label' => 'Ocupación promedio (%)',
            'data' => $data,
            'borderWidth' => 1,
        ]];

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
                    'legend' => [
                        'display' => true,
                        'position' => 'bottom',
                    ],
                    'tooltip' => [
                        'enabled' => true,
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
        return view('livewire.public-interface.charts.accommodation-season-vs-occupancy');
    }
}
