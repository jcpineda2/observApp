<?php

namespace App\Livewire\PublicInterface\Charts;

use App\Models\Month;
use App\Models\TourismProviderStat;
use App\Models\Year;
use Illuminate\Support\Str;
use Livewire\Component;

class ProvidersYoYStockByMonth extends Component
{
    public ?int $year = null;   // year_id (año seleccionado)
    public ?int $month = null;  // month_id (opcional)

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

        // Encontrar año anterior por valor (no por id)
        $selectedYearValue = Year::query()->whereKey($this->year)->value('year');
        $prevYearId = Year::query()->where('year', ((int)$selectedYearValue) - 1)->value('id');

        $months = Month::query()->orderBy('month_number')->get(['id', 'month', 'month_number']);

        // Stock nacional (mensual) del año seleccionado:
        // Usamos MAX(total_registered) por mes para no inflar.
        $current = TourismProviderStat::query()
            ->where('year_id', $this->year)
            ->when($this->month, fn ($q) => $q->where('month_id', $this->month))
            ->selectRaw('month_id, MAX(total_registered) as stock')
            ->groupBy('month_id')
            ->pluck('stock', 'month_id')
            ->toArray();

        // Stock año anterior (si existe)
        $previous = [];
        if ($prevYearId) {
            $previous = TourismProviderStat::query()
                ->where('year_id', $prevYearId)
                ->when($this->month, fn ($q) => $q->where('month_id', $this->month))
                ->selectRaw('month_id, MAX(total_registered) as stock')
                ->groupBy('month_id')
                ->pluck('stock', 'month_id')
                ->toArray();
        }

        // Labels + serie YoY%
        if ($this->month) {
            $selected = $months->firstWhere('id', $this->month);
            $this->labels = [$selected?->month ?? 'Mes'];

            $curr = (float) ($current[$this->month] ?? 0);
            $prev = (float) ($previous[$this->month] ?? 0);

            $yoy = ($prev > 0) ? (($curr - $prev) / $prev) * 100 : 0.0;
            $yoyData = [round($yoy, 2)];
        } else {
            $this->labels = $months->pluck('month')->toArray();

            $yoyData = [];
            foreach ($months as $m) {
                $curr = (float) ($current[$m->id] ?? 0);
                $prev = (float) ($previous[$m->id] ?? 0);

                $yoyData[] = round(($prev > 0) ? (($curr - $prev) / $prev) * 100 : 0.0, 2);
            }
        }

        $this->datasets = [[
            'label' => 'Variación interanual (%) - Stock PST',
            'data' => $yoyData,
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
                'animation' => false, // ✅ evita error ctx.save al cambiar tabs/filtros
                'plugins' => [
                    'legend' => ['position' => 'bottom'],
                    'tooltip' => ['enabled' => true],
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
            config: $this->chartConfig(),
        );
    }

    public function render()
    {
        return view('livewire.public-interface.charts.providers-yo-y-stock-by-month');
    }
}
