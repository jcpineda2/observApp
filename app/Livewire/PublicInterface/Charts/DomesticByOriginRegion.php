<?php

namespace App\Livewire\PublicInterface\Charts;

use App\Models\DomesticTourism;
use App\Models\Year;
use Illuminate\Support\Str;
use Livewire\Component;

class DomesticByOriginRegion extends Component
{
    public ?int $year = null;   // year_id
    public ?int $month = null;  // month_id (opcional)

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

        // Total general (para calcular "Otros")
        $totalAll = (int) DomesticTourism::query()
            ->where('year_id', $this->year)
            ->when($this->month, fn ($q) => $q->where('month_id', $this->month))
            ->sum('tourist_quantity');

        // Top 10 regiones de origen (origin_region es string)
        $top = DomesticTourism::query()
            ->where('year_id', $this->year)
            ->when($this->month, fn ($q) => $q->where('month_id', $this->month))
            ->selectRaw('COALESCE(NULLIF(origin_region, ""), "Sin región") as region, SUM(tourist_quantity) as total')
            ->groupBy('region')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $labels = $top->pluck('region')->toArray();
        $data   = $top->pluck('total')->map(fn ($v) => (int) $v)->toArray();

        $sumTop = array_sum($data);
        $others = max(0, $totalAll - $sumTop);

        // Top 10 + Otros
        $labels[] = 'Otros';
        $data[]   = $others;

        $this->labels = $labels;

        $this->datasets = [[
            'label' => 'Turistas internos',
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
                'animation' => false, // ✅ clave para evitar ctx.save
                'plugins' => [
                    'legend' => ['display' => false],
                    'tooltip' => ['enabled' => true],
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
        $this->dispatch('observatorio:chart:update', chartId: $this->chartId, config: $this->chartConfig());
    }

    public function render()
    {
        return view('livewire.public-interface.charts.domestic-by-origin-region');
    }
}
