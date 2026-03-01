<?php

namespace App\Livewire\PublicInterface\Charts;

use App\Models\DomesticTourism;
use App\Models\Month;
use App\Models\Year;
use Illuminate\Support\Str;
use Livewire\Component;

class DomesticSpendByMonth extends Component
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

        // SUM(total_spend) por mes
        $totals = DomesticTourism::query()
            ->where('year_id', $this->year)
            ->when($this->month, fn ($q) => $q->where('month_id', $this->month))
            ->selectRaw('month_id, SUM(total_spend) as total')
            ->groupBy('month_id')
            ->pluck('total', 'month_id')
            ->toArray();

        if ($this->month) {
            $selected = $months->firstWhere('id', $this->month);
            $this->labels = [$selected?->month ?? 'Mes'];

            $data = [(float)($totals[$this->month] ?? 0)];
        } else {
            $this->labels = $months->pluck('month')->toArray();

            $data = [];
            foreach ($months as $m) {
                $data[] = (float)($totals[$m->id] ?? 0);
            }
        }

        $this->datasets = [[
            'label' => 'Gasto total',
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
        return view('livewire.public-interface.charts.domestic-spend-by-month');
    }
}
