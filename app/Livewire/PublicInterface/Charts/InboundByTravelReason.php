<?php

namespace App\Livewire\PublicInterface\Charts;

use App\Models\InboundTourism;
use App\Models\Year;
use Illuminate\Support\Str;
use Livewire\Component;

class InboundByTravelReason extends Component
{
    public ?int $year = null;   // year_id
    public ?int $month = null;  // month_id (opcional)

    public string $chartId;

    // Para motivos conviene doughnut/pie (visual tipo observatorio)
    public string $type = 'doughnut';
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

        // Agrupa por motivo de viaje (travel_reasons.description)
        $rows = InboundTourism::query()
            ->where('inbound_tourisms.year_id', $this->year)
            ->when($this->month, fn ($q) => $q->where('inbound_tourisms.month_id', $this->month))
            ->leftJoin('travel_reasons', 'travel_reasons.id', '=', 'inbound_tourisms.travel_reason_id')
            ->selectRaw('COALESCE(travel_reasons.description, "Sin motivo") as reason, SUM(inbound_tourisms.tourist_arrivals) as total')
            ->groupBy('reason')
            ->orderByDesc('total')
            ->get();

        $this->labels = $rows->pluck('reason')->toArray();
        $data = $rows->pluck('total')->map(fn ($v) => (int) $v)->toArray();

        $this->datasets = [[
            'label' => 'Llegadas (turistas)',
            'data' => $data,
            // ⚠️ No especificamos colores (tu identidad la ajustás en Tailwind luego)
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
                'animation' => false, // ✅ evita crash al cambiar tabs/filtros
                'plugins' => [
                    'legend' => [
                        'display' => true,
                        'position' => 'bottom',
                    ],
                    'tooltip' => ['enabled' => true],
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
        return view('livewire.public-interface.charts.inbound-by-travel-reason');
    }
}
