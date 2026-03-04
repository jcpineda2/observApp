<?php

namespace App\Livewire\PublicInterface\Charts;

use App\Models\DomesticTourism;
use App\Models\Month;
use App\Models\Year;
use Illuminate\Support\Str;
use Livewire\Component;

class DomesticTourismByMonth extends Component
{
    public ?int $year = null;
    public ?int $month = null;

    public string $chartId;

    public string $title = 'Turistas internos por mes';
    public ?string $subtitle = null;

    public string $type = 'line';
    public array $labels = [];
    public array $datasets = [];

    public int $height = 280;

    protected $listeners = [
        'public-filters-updated' => 'onFiltersUpdated',
    ];

    public function mount(): void
    {
        $this->chartId = 'chart_' . Str::random(10);

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
            $this->subtitle = 'Seleccioná un año para ver la evolución mensual.';
            $this->dispatchUpdate();
            return;
        }

        $months = Month::query()
            ->orderBy('month_number')
            ->get(['id', 'month', 'month_number']);

        $totalsByMonth = DomesticTourism::query()
            ->where('year_id', $this->year)
            // ⚠️ Importante: si filtras por month_id, ya no es "por mes", es un solo punto.
            // Lo dejamos porque vos lo querés así.
            ->when($this->month, fn ($q) => $q->where('month_id', $this->month))
            ->selectRaw('month_id, SUM(tourist_quantity) as total')
            ->groupBy('month_id')
            ->pluck('total', 'month_id')
            ->toArray();

        if ($this->month) {
            $selected = $months->firstWhere('id', $this->month);
            $this->labels = [$selected?->month ?? 'Mes'];
            $this->datasets = [[
                'label' => 'Turistas internos',
                'data' => [(int) ($totalsByMonth[$this->month] ?? 0)],
                'borderWidth' => 2,
                'tension' => 0.3,
            ]];

            $this->subtitle = 'Filtro aplicado: Año + Mes';
        } else {
            $this->labels = $months->pluck('month')->toArray();
            $data = [];

            foreach ($months as $m) {
                $data[] = (int) ($totalsByMonth[$m->id] ?? 0);
            }

            $this->datasets = [[
                'label' => 'Turistas internos',
                'data' => $data,
                'borderWidth' => 2,
                'tension' => 0.3,
            ]];

            $this->subtitle = 'Filtro aplicado: Año';
        }

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
                    'legend' => ['display' => true, 'position' => 'bottom'],
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
        return view('livewire.public-interface.charts.domestic-tourism-by-month');
    }
}
