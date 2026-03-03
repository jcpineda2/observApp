<?php

namespace App\Livewire\PublicInterface\Charts;

use App\Models\DomesticTourism;
use App\Models\Month;
use App\Models\Year;
use Illuminate\Support\Str;
use Livewire\Component;

class DomesticAverageStayByMonth extends Component
{
    public ?int $year = null;   // year_id
    public ?int $month = null;  // month_id (opcional)

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

        // 1) Serie simple: AVG(average_stay) por mes
        $avgSimple = DomesticTourism::query()
            ->where('year_id', $this->year)
            ->when($this->month, fn ($q) => $q->where('month_id', $this->month))
            ->selectRaw('month_id, AVG(average_stay) as avg_stay')
            ->groupBy('month_id')
            ->pluck('avg_stay', 'month_id')
            ->toArray();

        // 2) Serie ponderada: SUM(average_stay * tourist_quantity) / SUM(tourist_quantity)
        // Lo calculamos por mes con un selectRaw.
        $weightedRows = DomesticTourism::query()
            ->where('year_id', $this->year)
            ->when($this->month, fn ($q) => $q->where('month_id', $this->month))
            ->selectRaw('
                month_id,
                SUM(average_stay * tourist_quantity) as weighted_sum,
                SUM(tourist_quantity) as qty_sum
            ')
            ->groupBy('month_id')
            ->get();

        $avgWeighted = [];
        foreach ($weightedRows as $row) {
            $qty = (float) ($row->qty_sum ?? 0);
            $ws  = (float) ($row->weighted_sum ?? 0);
            $avgWeighted[$row->month_id] = $qty > 0 ? ($ws / $qty) : 0.0;
        }

        // Labels + data (si viene month, mostramos un punto)
        if ($this->month) {
            $selected = $months->firstWhere('id', $this->month);
            $this->labels = [$selected?->month ?? 'Mes'];

            $simpleData   = [ (float) ($avgSimple[$this->month] ?? 0) ];
            $weightedData = [ (float) ($avgWeighted[$this->month] ?? 0) ];
        } else {
            $this->labels = $months->pluck('month')->toArray();

            $simpleData = [];
            $weightedData = [];

            foreach ($months as $m) {
                $simpleData[]   = (float) ($avgSimple[$m->id] ?? 0);
                $weightedData[] = (float) ($avgWeighted[$m->id] ?? 0);
            }
        }

        $this->datasets = [
            [
                'label' => 'Estadía promedio (simple)',
                'data' => $simpleData,
                'borderWidth' => 2,
                'tension' => 0.3,
            ],
            [
                'label' => 'Estadía promedio (ponderada)',
                'data' => $weightedData,
                'borderWidth' => 2,
                'tension' => 0.3,
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
                'animation' => false, // ✅ evita ctx.save en cambios de tab/filtros
                'plugins' => [
                    'legend' => [
                        'display' => true,
                        'position' => 'bottom',
                    ],
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
        return view('livewire.public-interface.charts.domestic-average-stay-by-month');
    }
}
