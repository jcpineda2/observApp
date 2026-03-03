<?php

namespace App\Livewire\PublicInterface\Charts;

use App\Models\EmploymentDemographic;
use App\Models\Year;
use Illuminate\Support\Str;
use Livewire\Component;

class EmploymentByAge extends Component
{
    public ?int $year = null;
    public ?int $month = null; // anual

    public string $chartId;
    public string $type = 'bar';

    public array $labels = [];
    public array $datasets = [];

    public int $totalPeople = 0;

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
        $this->year = $year ?: null;
        $this->month = $month ?: null;

        $this->buildChart();
    }

    private function buildChart(): void
    {
        if (! $this->year) {
            $this->labels = [];
            $this->datasets = [];
            $this->totalPeople = 0;
            $this->dispatchUpdate();
            return;
        }

        $rows = EmploymentDemographic::query()
            ->leftJoin('tourism_employments', 'tourism_employments.id', '=', 'employment_demographics.tourism_employment_id')
            ->where('tourism_employments.year_id', $this->year)
            ->selectRaw('employment_demographics.age_range as age, SUM(employment_demographics.people_count) as total')
            ->groupBy('age')
            ->orderBy('age')
            ->get();

        $this->labels = $rows->pluck('age')->map(fn ($v) => (string) $v)->toArray();

        $data = $rows->pluck('total')->map(fn ($v) => (int) $v)->toArray();

        $this->totalPeople = array_sum($data);

        $this->datasets = [[
            'label' => 'Personas',
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
                'indexAxis' => 'y', // 👈 barras horizontales
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
        return view('livewire.public-interface.charts.employment-by-age');
    }
}
