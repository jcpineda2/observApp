<?php

namespace App\Livewire\PublicInterface\Charts;

use App\Models\Month;
use App\Models\TourismProviderStat;
use App\Models\Year;
use Illuminate\Support\Str;
use Livewire\Component;

class ProvidersRegistrationsCancellationsByMonth extends Component
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

        $months = Month::query()->orderBy('month_number')->get(['id', 'month', 'month_number']);

        $rows = TourismProviderStat::query()
            ->where('year_id', $this->year)
            ->when($this->month, fn ($q) => $q->where('month_id', $this->month))
            ->selectRaw('month_id, SUM(registrations) as regs, SUM(cancellations) as canc')
            ->groupBy('month_id')
            ->pluck('regs', 'month_id'); // usamos para presence; luego consultamos canc aparte

        $rowsCanc = TourismProviderStat::query()
            ->where('year_id', $this->year)
            ->when($this->month, fn ($q) => $q->where('month_id', $this->month))
            ->selectRaw('month_id, SUM(cancellations) as canc')
            ->groupBy('month_id')
            ->pluck('canc', 'month_id')
            ->toArray();

        if ($this->month) {
            $selected = $months->firstWhere('id', $this->month);
            $this->labels = [$selected?->month ?? 'Mes'];

            $regs = [(int) ($rows[$this->month] ?? 0)];
            $canc = [(int) ($rowsCanc[$this->month] ?? 0)];
        } else {
            $this->labels = $months->pluck('month')->toArray();

            $regs = [];
            $canc = [];

            foreach ($months as $m) {
                $regs[] = (int) ($rows[$m->id] ?? 0);
                $canc[] = (int) ($rowsCanc[$m->id] ?? 0);
            }
        }

        $this->datasets = [
            [
                'label' => 'Altas',
                'data' => $regs,
                'borderWidth' => 1,
            ],
            [
                'label' => 'Bajas',
                'data' => $canc,
                'borderWidth' => 1,
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
                'animation' => false, // ✅ importante para evitar ctx null en tabs/filtros
                'plugins' => [
                    'legend' => ['position' => 'bottom'],
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
        return view('livewire.public-interface.charts.providers-registrations-cancellations-by-month');
    }
}
