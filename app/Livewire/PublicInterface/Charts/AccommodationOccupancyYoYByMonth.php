<?php

namespace App\Livewire\PublicInterface\Charts;

use App\Models\AccommodationPerformance;
use App\Models\Month;
use App\Models\Year;
use Illuminate\Support\Str;
use Livewire\Component;

class AccommodationOccupancyYoYByMonth extends Component
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
            return;
        }

        $selectedYearValue = (int) Year::whereKey($this->year)->value('year');
        $prevYearId = Year::where('year', $selectedYearValue - 1)->value('id');

        $months = Month::orderBy('month_number')->get(['id', 'month']);

        $current = AccommodationPerformance::query()
            ->where('year_id', $this->year)
            ->selectRaw('month_id, AVG(occupancy_rate) as avg_occ')
            ->groupBy('month_id')
            ->pluck('avg_occ', 'month_id')
            ->toArray();

        $previous = [];

        if ($prevYearId) {
            $previous = AccommodationPerformance::query()
                ->where('year_id', $prevYearId)
                ->selectRaw('month_id, AVG(occupancy_rate) as avg_occ')
                ->groupBy('month_id')
                ->pluck('avg_occ', 'month_id')
                ->toArray();
        }

        $labels = [];
        $currentData = [];
        $previousData = [];
        $yoyValues = [];

        foreach ($months as $m) {
            $labels[] = $m->month;

            $curr = round((float) ($current[$m->id] ?? 0), 2);
            $prev = round((float) ($previous[$m->id] ?? 0), 2);

            $currentData[] = $curr;
            $previousData[] = $prev;

            if ($prev > 0) {
                $yoyValues[] = (($curr - $prev) / $prev) * 100;
            }
        }

        $this->yoyAverage = count($yoyValues) > 0
            ? round(array_sum($yoyValues) / count($yoyValues), 2)
            : 0;

        $this->labels = $labels;

        $this->datasets = [
            [
                'label' => "Ocupación {$selectedYearValue}",
                'data' => $currentData,
                'borderWidth' => 2,
                'tension' => 0.3,
            ],
            [
                'label' => "Ocupación " . ($selectedYearValue - 1),
                'data' => $previousData,
                'borderWidth' => 2,
                'borderDash' => [5,5],
                'tension' => 0.3,
            ],
        ];

        $this->dispatchUpdate();
    }

    private function chartConfig(): array
    {
        return [
            'type' => 'line',
            'data' => [
                'labels' => $this->labels,
                'datasets' => $this->datasets,
            ],
            'options' => [
                'responsive' => true,
                'maintainAspectRatio' => false,
                'animation' => false,
                'scales' => [
                    'y' => [
                        'min' => 0,
                        'max' => 100,
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
        return view('livewire.public-interface.charts.accommodation-occupancy-yo-y-by-month');
    }
}
