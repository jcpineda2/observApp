<?php

namespace App\Livewire\PublicInterface\Charts;

use App\Models\AirConnectivityRoute;
use App\Models\Year;
use Illuminate\Support\Str;
use Livewire\Component;

class TopAirportsByMetric extends Component
{
    public ?int $year = null;
    public ?int $month = null;

    // origin | destination
    public string $role = 'origin';

    // seats | flights
    public string $metric = 'seats';

    public int $limit = 10;

    public string $chartId;
    public string $type = 'bar';

    public array $labels = [];
    public array $datasets = [];

    protected $listeners = [
        'public-filters-updated' => 'onFiltersUpdated',
        'air-metric-changed'     => 'onMetricChanged',
    ];

    public function mount(string $role = 'origin'): void
    {
        $this->role = in_array($role, ['origin', 'destination'], true) ? $role : 'origin';
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

    public function onMetricChanged(string $metric): void
    {
        $this->metric = in_array($metric, ['seats', 'flights'], true) ? $metric : 'seats';
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

        $airportJoinCol = $this->role === 'origin'
            ? 'air_connectivity_routes.origin_airport_id'
            : 'air_connectivity_routes.destination_airport_id';

        $sumCol = $this->metric === 'flights' ? 'flights_count' : 'seats_count';
        $label  = $this->metric === 'flights' ? 'Vuelos' : 'Asientos';

        // ⚠️ Ajuste típico: airports.name vs airports.description
        $rows = AirConnectivityRoute::query()
            ->leftJoin('airports as a', 'a.id', '=', $airportJoinCol)
            ->where('air_connectivity_routes.year_id', $this->year)
            ->when($this->month, fn ($q) => $q->where('air_connectivity_routes.month_id', $this->month))
            ->selectRaw('COALESCE(a.name, a.name, "Aeropuerto") as airport, SUM(air_connectivity_routes.' . $sumCol . ') as total')
            ->groupBy('airport')
            ->orderByDesc('total')
            ->limit($this->limit)
            ->get();

        $this->labels = $rows->pluck('airport')->toArray();
        $data = $rows->pluck('total')->map(fn ($v) => (int) $v)->toArray();

        $this->datasets = [[
            'label' => $label,
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
                'indexAxis' => 'y',
                'responsive' => true,
                'maintainAspectRatio' => false,
                'animation' => false,
                'plugins' => [
                    'legend' => ['display' => false],
                ],
                'scales' => [
                    'x' => ['beginAtZero' => true],
                    'y' => ['grid' => ['display' => false]],
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
        return view('livewire.public-interface.charts.top-airports-by-metric');
    }
}
