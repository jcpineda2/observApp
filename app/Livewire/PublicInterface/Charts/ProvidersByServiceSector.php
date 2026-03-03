<?php

namespace App\Livewire\PublicInterface\Charts;

use App\Models\TourismProviderStat;
use App\Models\Year;
use Illuminate\Support\Str;
use Livewire\Component;

class ProvidersByServiceSector extends Component
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

        // Total nacional (stock) del período: MAX(total_registered)
        $totalAll = (int) TourismProviderStat::query()
            ->where('year_id', $this->year)
            ->when($this->month, fn ($q) => $q->where('month_id', $this->month))
            ->max('total_registered');

        // Top 10 rubros por stock (MAX total_registered por rubro)
        $top = TourismProviderStat::query()
            ->where('tourism_provider_stats.year_id', $this->year)
            ->when($this->month, fn ($q) => $q->where('tourism_provider_stats.month_id', $this->month))
            ->leftJoin('service_sectors', 'service_sectors.id', '=', 'tourism_provider_stats.service_sector_id')
            ->selectRaw('COALESCE(service_sectors.description, "Sin rubro") as sector, MAX(tourism_provider_stats.total_registered) as stock')
            ->groupBy('sector')
            ->orderByDesc('stock')
            ->limit(10)
            ->get();

        $labels = $top->pluck('sector')->toArray();
        $data   = $top->pluck('stock')->map(fn ($v) => (int) $v)->toArray();

        $sumTop = array_sum($data);
        $others = max(0, $totalAll - $sumTop);

        $labels[] = 'Otros';
        $data[]   = $others;

        $this->labels = $labels;

        $this->datasets = [[
            'label' => 'Prestadores registrados (stock)',
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
                'animation' => false, // ✅ evita ctx.save
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
        return view('livewire.public-interface.charts.providers-by-service-sector');
    }
}
