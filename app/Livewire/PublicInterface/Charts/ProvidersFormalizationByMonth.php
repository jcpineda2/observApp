<?php

namespace App\Livewire\PublicInterface\Charts;

use App\Models\Month;
use App\Models\TourismProviderStat;
use App\Models\Year;
use Illuminate\Support\Str;
use Livewire\Component;

class ProvidersFormalizationByMonth extends Component
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

        $months = Month::query()->orderBy('month_number')->get(['id', 'month', 'month_number']);

        // SUM formalized por mes
        $formalized = TourismProviderStat::query()
            ->where('year_id', $this->year)
            ->when($this->month, fn ($q) => $q->where('month_id', $this->month))
            ->selectRaw('month_id, SUM(formalized_total) as total')
            ->groupBy('month_id')
            ->pluck('total', 'month_id')
            ->toArray();

        // MAX stock por mes
        $stock = TourismProviderStat::query()
            ->where('year_id', $this->year)
            ->when($this->month, fn ($q) => $q->where('month_id', $this->month))
            ->selectRaw('month_id, MAX(total_registered) as stock')
            ->groupBy('month_id')
            ->pluck('stock', 'month_id')
            ->toArray();

        if ($this->month) {
            $selected = $months->firstWhere('id', $this->month);
            $this->labels = [$selected?->month ?? 'Mes'];

            $f = (float) ($formalized[$this->month] ?? 0);
            $s = (float) ($stock[$this->month] ?? 0);

            $pct = ($s > 0) ? ($f / $s) * 100 : 0;

            $data = [round($pct, 2)];
        } else {
            $this->labels = $months->pluck('month')->toArray();

            $data = [];
            foreach ($months as $m) {
                $f = (float) ($formalized[$m->id] ?? 0);
                $s = (float) ($stock[$m->id] ?? 0);

                $data[] = round(($s > 0 ? ($f / $s) * 100 : 0), 2);
            }
        }

        $this->datasets = [[
            'label' => '% Formalización',
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
                    'legend' => ['position' => 'bottom'],
                ],
                'scales' => [
                    'x' => ['grid' => ['display' => false]],
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
        return view('livewire.public-interface.charts.providers-formalization-by-month');
    }
}
