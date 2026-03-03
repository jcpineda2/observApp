<?php

namespace App\Livewire\PublicInterface\Charts;

use App\Models\AccommodationPerformance;
use App\Models\Month;
use App\Models\Year;
use Illuminate\Support\Str;
use Livewire\Component;

class AccommodationOccupancyByMonth extends Component
{
    public ?int $year = null;
    public ?int $month = null;

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

        $months = Month::query()
            ->orderBy('month_number')
            ->get(['id', 'month', 'month_number']);

        // AVG ocupación por mes
        $avgByMonth = AccommodationPerformance::query()
            ->where('year_id', $this->year)
            ->when($this->month, fn ($q) => $q->where('month_id', $this->month))
            ->selectRaw('month_id, AVG(occupancy_rate) as avg_occ')
            ->groupBy('month_id')
            ->pluck('avg_occ', 'month_id')
            ->toArray();

        if ($this->month) {
            $selected = $months->firstWhere('id', $this->month);

            $this->labels = [$selected?->month ?? 'Mes'];

            $data = [
                round((float) ($avgByMonth[$this->month] ?? 0), 2)
            ];
        } else {
            $this->labels = $months->pluck('month')->toArray();

            $data = [];
            foreach ($months as $m) {
                $data[] = round((float) ($avgByMonth[$m->id] ?? 0), 2);
            }
        }

        $this->datasets = [[
            'label' => 'Ocupación promedio (%)',
            'data' => $data,
            'borderWidth' => 2,
            'tension' => 0.3,
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
                        'position' => 'bottom',
                    ],
                ],
                'scales' => [
                    'x' => [
                        'grid' => ['display' => false],
                    ],
                    'y' => [
                        'beginAtZero' => true,
                    ],
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
        return view('livewire.public-interface.charts.accommodation-occupancy-by-month');
    }
}
