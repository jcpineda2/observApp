<?php

namespace App\Livewire\PublicInterface\Charts;

use App\Models\AirConnectivityRoute;
use App\Models\Month;
use App\Models\Year;
use Illuminate\Support\Str;
use Livewire\Component;

class AirConnectivityFlightsSeatsByMonth extends Component
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
        $this->year = $year ?: null;
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

        $months = Month::query()->orderBy('month_number')->get(['id', 'month', 'month_number']);

        $this->labels = $this->month
            ? [($months->firstWhere('id', $this->month)?->month ?? 'Mes')]
            : $months->pluck('month')->toArray();

        $rows = AirConnectivityRoute::query()
            ->where('year_id', $this->year)
            ->when($this->month, fn ($q) => $q->where('month_id', $this->month))
            ->selectRaw('month_id, SUM(flights_count) as flights, SUM(seats_count) as seats')
            ->groupBy('month_id')
            ->pluck('flights', 'month_id'); // flights map

        $rowsSeats = AirConnectivityRoute::query()
            ->where('year_id', $this->year)
            ->when($this->month, fn ($q) => $q->where('month_id', $this->month))
            ->selectRaw('month_id, SUM(seats_count) as seats')
            ->groupBy('month_id')
            ->pluck('seats', 'month_id');

        $flightsData = [];
        $seatsData = [];

        if ($this->month) {
            $flightsData = [(int) ($rows[$this->month] ?? 0)];
            $seatsData   = [(int) ($rowsSeats[$this->month] ?? 0)];
        } else {
            foreach ($months as $m) {
                $flightsData[] = (int) ($rows[$m->id] ?? 0);
                $seatsData[]   = (int) ($rowsSeats[$m->id] ?? 0);
            }
        }

        $this->datasets = [
            [
                'label' => 'Vuelos',
                'data' => $flightsData,
                'borderWidth' => 2,
                'tension' => 0.3,
                'yAxisID' => 'y',
            ],
            [
                'label' => 'Asientos',
                'data' => $seatsData,
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
                    'x' => ['grid' => ['display' => false]],
                    'y' => [
                        'beginAtZero' => true,
                        'title' => ['display' => true, 'text' => 'Vuelos'],
                    ],
                    'y1' => [
                        'beginAtZero' => true,
                        'position' => 'right',
                        'grid' => ['drawOnChartArea' => false],
                        'title' => ['display' => true, 'text' => 'Asientos'],
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
        return view('livewire.public-interface.charts.air-connectivity-flights-seats-by-month');
    }
}
