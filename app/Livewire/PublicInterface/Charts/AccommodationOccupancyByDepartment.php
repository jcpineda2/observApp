<?php

namespace App\Livewire\PublicInterface\Charts;

use App\Models\AccommodationPerformance;
use App\Models\State;
use App\Models\Year;
use Illuminate\Support\Str;
use Livewire\Component;

class AccommodationOccupancyByDepartment extends Component
{
    public ?int $year = null;
    public ?int $month = null;

    public string $chartId;
    public string $type = 'bar';

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

        $rows = AccommodationPerformance::query()
            ->where('accommodation_performances.year_id', $this->year)
            ->when($this->month, fn ($q) => $q->where('accommodation_performances.month_id', $this->month))
            ->leftJoin('states', 'states.id', '=', 'accommodation_performances.state_id')
            ->selectRaw('COALESCE(states.description, "Sin depto") as depto, AVG(accommodation_performances.occupancy_rate) as avg_occ')
            ->groupBy('depto')
            ->orderByDesc('avg_occ')
            ->limit(12)
            ->get();

        $this->labels = $rows->pluck('depto')->toArray();
        $data = $rows->pluck('avg_occ')->map(fn ($v) => round((float) $v, 2))->toArray();

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
                    'legend' => ['display' => false],
                ],
                'scales' => [
                    'x' => ['grid' => ['display' => false]],
                    'y' => ['beginAtZero' => true],
                ],
            ],
        ];
    }

    private function dispatchUpdate(): void
    {
        $this->dispatch(
            'observatorio:chart:update',
            chartId: $this->chartId,
            config: $this->chartConfig()
        );
    }

    public function render()
    {
        return view('livewire.public-interface.charts.accommodation-occupancy-by-department');
    }
}
