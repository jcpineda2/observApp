<?php

namespace App\Livewire\PublicInterface\Charts;

use App\Models\TourismEmployment;
use App\Models\Year;
use Illuminate\Support\Str;
use Livewire\Component;

class EmploymentByServiceSector extends Component
{
    public ?int $year = null;
    public ?int $month = null; // anual, se ignora

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
        $this->year = $year ?: null;
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

        $rows = TourismEmployment::query()
            ->where('tourism_employments.year_id', $this->year)
            ->leftJoin('service_sectors', 'service_sectors.id', '=', 'tourism_employments.service_sector_id')
            ->selectRaw('COALESCE(service_sectors.description, service_sectors.description, "Sin rubro") as sector, SUM(tourism_employments.direct_employment) as total')
            ->groupBy('sector')
            ->orderByDesc('total')
            ->get();

        // Si service_sectors no tiene description, cambiá por solo name (como ya te pasó con categorías)
        $this->labels = $rows->pluck('sector')->toArray();
        $data = $rows->pluck('total')->map(fn($v) => (int)$v)->toArray();

        $this->datasets = [[
            'label' => 'Empleo directo',
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
                    'legend' => ['display' => false],
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
        return view('livewire.public-interface.charts.employment-by-service-sector');
    }
}
