<?php

namespace App\Livewire\PublicInterface\Charts;

use App\Models\Accommodation;
use App\Models\Year;
use Illuminate\Support\Str;
use Livewire\Component;

class AccommodationByCategory extends Component
{
    public ?int $year = null;
    public ?int $month = null;

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

        // Aunque el gráfico es “stock”, mantenemos el listener para coherencia del layout
        $this->buildChart();
    }

    private function buildChart(): void
    {
        $totalAll = (int) \App\Models\AccommodationPerformance::query()
            ->where('year_id', $this->year)
            ->when($this->month, fn($q) => $q->where('month_id', $this->month))
            ->distinct('accommodation_id')
            ->count('accommodation_id');

        $top = \App\Models\AccommodationPerformance::query()
            ->where('accommodation_performances.year_id', $this->year)
            ->when($this->month, fn($q) => $q->where('accommodation_performances.month_id', $this->month))
            ->leftJoin('accommodations', 'accommodations.id', '=', 'accommodation_performances.accommodation_id')
            ->leftJoin('accommodation_categories', 'accommodation_categories.id', '=', 'accommodations.accommodation_category_id')
            ->selectRaw('COALESCE(accommodation_categories.category, accommodation_categories.category, "Sin categoría") as category, COUNT(DISTINCT accommodation_performances.accommodation_id) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $labels = $top->pluck('category')->toArray();
        $data   = $top->pluck('total')->map(fn($v) => (int) $v)->toArray();

        $sumTop = array_sum($data);
        $others = max(0, $totalAll - $sumTop);

        $labels[] = 'Otros';
        $data[]   = $others;

        $this->labels = $labels;

        $this->datasets = [[
            'label' => 'Establecimientos',
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
        return view('livewire.public-interface.charts.accommodation-by-category');
    }
}
