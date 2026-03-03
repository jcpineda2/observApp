<?php

namespace App\Livewire\PublicInterface\Charts;

use App\Models\DomesticTourism;
use App\Models\Year;
use Illuminate\Support\Str;
use Livewire\Component;

class DomesticByDestinationDepartment extends Component
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

        // Top 10 departamentos destino
        // destination_department_id -> states
        // En el paquete de states normalmente el nombre es `name`
        $top = DomesticTourism::query()
            ->where('domestic_tourisms.year_id', $this->year)
            ->when($this->month, fn ($q) => $q->where('domestic_tourisms.month_id', $this->month))
            ->leftJoin('states', 'states.id', '=', 'domestic_tourisms.destination_department_id')
            ->selectRaw('COALESCE(states.name, "Sin departamento") as department, SUM(domestic_tourisms.tourist_quantity) as total')
            ->groupBy('department')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $labels = $top->pluck('department')->toArray();
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
                'animation' => false, // ✅ evita el error ctx.save al cambiar tabs/filtros
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
        return view('livewire.public-interface.charts.domestic-by-destination-department');
    }
}
