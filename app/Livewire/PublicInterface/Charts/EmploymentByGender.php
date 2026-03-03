<?php

namespace App\Livewire\PublicInterface\Charts;

use App\Models\EmploymentDemographic;
use App\Models\Year;
use Illuminate\Support\Str;
use Livewire\Component;

class EmploymentByGender extends Component
{
    public ?int $year = null;
    public ?int $month = null; // anual: ignorado

    public string $chartId;
    public string $type = 'doughnut';

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
        $this->year  = $year ?: null;
        $this->month = $month ?: null; // se ignora
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

        // Sumamos people_count por gender, filtrando por year vía tourism_employments
        $rows = EmploymentDemographic::query()
            ->leftJoin('tourism_employments', 'tourism_employments.id', '=', 'employment_demographics.tourism_employment_id')
            ->where('tourism_employments.year_id', $this->year)
            ->selectRaw('employment_demographics.gender as g, SUM(employment_demographics.people_count) as total')
            ->groupBy('g')
            ->orderByDesc('total')
            ->get();

        $this->labels = $rows->pluck('g')->map(function ($g) {
            // Como gender está casteado a Enum, en DB suele guardarse como string.
            // Esto lo dejamos “tolerante”.
            if (is_null($g) || $g === '') return 'No especificado';

            $val = (string) $g;
            return match (strtolower($val)) {
                'm', 'male', 'masculino' => 'Masculino',
                'f', 'female', 'femenino' => 'Femenino',
                default => ucfirst($val),
            };
        })->toArray();

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
                'responsive' => true,
                'maintainAspectRatio' => false,
                'animation' => false,
                'plugins' => [
                    'legend' => ['position' => 'bottom'],
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
        return view('livewire.public-interface.charts.employment-by-gender');
    }
}
