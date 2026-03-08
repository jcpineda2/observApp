<?php

namespace App\Livewire\PublicInterface\Charts;

use App\Models\InboundTourism;
use App\Models\Month;
use App\Models\Year;
use Illuminate\Support\Str;
use Livewire\Component;

class InboundTourismByMonth extends Component
{
    public ?int $year = null;

    public string $chartId;

    public string $type = 'line';

    public array $labels = [];
    public array $datasets = [];

    protected $listeners = [
        'public-filters-updated' => 'onFiltersUpdated',
    ];

    public function mount(): void
    {
        $this->chartId = 'chart_' . Str::random(10);

        if (! $this->year) {
            $this->year = Year::query()
                ->orderByDesc('year')
                ->value('id');
        }

        $this->buildChart();
    }

    public function onFiltersUpdated($year, $month): void
    {
        $this->year = $year ?: null;

        $this->buildChart();
    }

    private function buildChart(): void
    {
        if (! $this->year) {
            $this->labels = [];
            $this->datasets = [];
            return;
        }

        $months = Month::query()
            ->orderBy('month_number')
            ->get();

        $rows = InboundTourism::query()
            ->where('year_id', $this->year)
            ->selectRaw('month_id, SUM(tourist_arrivals) as total')
            ->groupBy('month_id')
            ->pluck('total', 'month_id');

        $this->labels = $months
            ->pluck('month')
            ->toArray();

        $data = $months
            ->map(fn ($month) => (int) ($rows[$month->id] ?? 0))
            ->toArray();

        $this->datasets = [
            [
                'label' => 'Llegadas de turistas',
                'data' => $data,
                'borderWidth' => 2,
                'tension' => 0.3,
            ]
        ];
    }

    public function render()
    {
        return view('livewire.public-interface.charts.inbound-tourism-by-month');
    }
}
