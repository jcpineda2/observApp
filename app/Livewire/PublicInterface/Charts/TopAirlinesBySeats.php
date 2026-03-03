<?php

namespace App\Livewire\PublicInterface\Charts;

use App\Models\AirConnectivityRoute;
use App\Models\Year;
use Illuminate\Support\Str;
use Livewire\Component;

class TopAirlinesBySeats extends Component
{
    public ?int $year = null;
    public ?int $month = null;

    public string $chartId;
    public string $type = 'bar';

    public array $labels = [];
    public array $datasets = [];

    public int $limit = 10;

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

        // 👇 Si air_lines no tiene 'name' y usa 'description', cambiá aquí:
        $rows = AirConnectivityRoute::query()
            ->leftJoin('air_lines', 'air_lines.id', '=', 'air_connectivity_routes.air_line_id')
            ->where('air_connectivity_routes.year_id', $this->year)
            ->when($this->month, fn ($q) => $q->where('air_connectivity_routes.month_id', $this->month))
            ->selectRaw('COALESCE(air_lines.name, air_lines.name, "Sin aerolínea") as airline, SUM(air_connectivity_routes.seats_count) as seats')
            ->groupBy('airline')
            ->orderByDesc('seats')
            ->limit($this->limit)
            ->get();

        $this->labels = $rows->pluck('airline')->toArray();
        $data = $rows->pluck('seats')->map(fn ($v) => (int) $v)->toArray();

        $this->datasets = [[
            'label' => 'Asientos',
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
                // Lo hacemos horizontal para que entren nombres largos:
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
        return view('livewire.public-interface.charts.top-airlines-by-seats');
    }
}
