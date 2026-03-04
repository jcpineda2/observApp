<?php

namespace App\Livewire\PublicInterface\Charts;

use App\Models\InboundTourism;
use App\Models\Month;
use App\Models\Year;
use Illuminate\Support\Str;
use Livewire\Component;

class InboundYoYArrivalsByMonth extends Component
{
    public ?int $year = null;
    public ?int $month = null;

    public string $chartId;
    public string $type = 'line';

    public array $labels = [];
    public array $datasets = [];

    public float $yoyAverage = 0.0;

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

        $selectedYearValue = (int) Year::whereKey($this->year)->value('year');
        $prevYearId = Year::where('year', $selectedYearValue - 1)->value('id');

        $months = Month::orderBy('month_number')->get(['id', 'month']);

        $current = InboundTourism::query()
            ->where('year_id', $this->year)
            ->selectRaw('month_id, SUM(tourist_arrivals) as total')
            ->groupBy('month_id')
            ->pluck('total', 'month_id')
            ->toArray();

        $previous = [];

        if ($prevYearId) {
            $previous = InboundTourism::query()
                ->where('year_id', $prevYearId)
                ->selectRaw('month_id, SUM(tourist_arrivals) as total')
                ->groupBy('month_id')
                ->pluck('total', 'month_id')
                ->toArray();
        }

        $labels = [];
        $currData = [];
        $prevData = [];
        $yoyValues = [];

        foreach ($months as $m) {
            $labels[] = $m->month;

            $curr = (int) ($current[$m->id] ?? 0);
            $prev = (int) ($previous[$m->id] ?? 0);

            $currData[] = $curr;
            $prevData[] = $prev;

            if ($prev > 0) {
                $yoyValues[] = (($curr - $prev) / $prev) * 100;
            }
        }

        $this->yoyAverage = count($yoyValues) > 0
            ? round(array_sum($yoyValues) / count($yoyValues), 2)
            : 0.0;

        $this->labels = $labels;

        $this->datasets = [
            [
                'label' => "Turistas {$selectedYearValue}",
                'data' => $currData,
                'borderWidth' => 2,
                'tension' => 0.3,
            ],
            [
                'label' => "Turistas " . ($selectedYearValue - 1),
                'data' => $prevData,
                'borderWidth' => 2,
                'borderDash' => [5, 5],
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
                'animation' => false,
                'plugins' => [
                    'legend' => ['position' => 'bottom'],
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
        $this->dispatch(
            'observatorio:chart:update',
            chartId: $this->chartId,
            config: $this->chartConfig()
        );
    }

    public function render()
    {
        return view('livewire.public-interface.charts.inbound-yo-y-arrivals-by-month');
    }
}
