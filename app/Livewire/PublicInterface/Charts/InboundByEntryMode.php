<?php

namespace App\Livewire\PublicInterface\Charts;

use App\Models\InboundTourism;
use App\Models\Year;
use Illuminate\Support\Str;
use Livewire\Component;

class InboundByEntryMode extends Component
{
    public ?int $year = null;   // year_id
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

        // Agrupa por vía de ingreso (entry_modes.description)
        $rows = InboundTourism::query()
            ->where('inbound_tourisms.year_id', $this->year)
            ->when($this->month, fn ($q) => $q->where('inbound_tourisms.month_id', $this->month))
            ->leftJoin('entry_modes', 'entry_modes.id', '=', 'inbound_tourisms.entry_mode_id')
            ->selectRaw('COALESCE(entry_modes.description, "Sin vía") as entry_mode, SUM(inbound_tourisms.tourist_arrivals) as total')
            ->groupBy('entry_mode')
            ->orderByDesc('total')
            ->get();

        $this->labels = $rows->pluck('entry_mode')->toArray();
        $data = $rows->pluck('total')->map(fn ($v) => (int) $v)->toArray();

        $this->datasets = [[
            'label' => 'Llegadas (turistas)',
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
                'animation' => false, // ✅ evita ctx null al cambiar tabs/filtros
                'plugins' => [
                    'legend' => ['display' => false],
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
        return view('livewire.public-interface.charts.inbound-by-entry-mode');
    }
}
