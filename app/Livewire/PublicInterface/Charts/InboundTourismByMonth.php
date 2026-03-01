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
    public ?int $month = null;

    public string $chartId;
    public array $labels = [];
    public array $datasets = [];
    public string $type = 'line';

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
        if (! $this->year) return;

        $months = Month::orderBy('month_number')->get();

        $totals = InboundTourism::query()
            ->where('year_id', $this->year)
            ->when($this->month, fn($q) => $q->where('month_id', $this->month))
            ->selectRaw('month_id, SUM(tourist_arrivals) as total')
            ->groupBy('month_id')
            ->pluck('total', 'month_id')
            ->toArray();

        $this->labels = $this->month
            ? [$months->firstWhere('id', $this->month)?->month]
            : $months->pluck('month')->toArray();

        $data = [];

        if ($this->month) {
            $data[] = (int) ($totals[$this->month] ?? 0);
        } else {
            foreach ($months as $m) {
                $data[] = (int) ($totals[$m->id] ?? 0);
            }
        }

        $this->datasets = [[
            'label' => 'Llegadas internacionales',
            'data' => $data,
            'borderWidth' => 2,
            'tension' => 0.3,
        ]];


        $this->dispatch('observatorio:chart:update', chartId: $this->chartId, config: [
            'type' => $this->type,
            'data' => [
                'labels' => $this->labels,
                'datasets' => $this->datasets,
            ],
            'options' => [
                'responsive' => true,
                'maintainAspectRatio' => false,
                'animation' => false,
            ],
        ]);
    }

    public function render()
    {
        return view('livewire.public-interface.charts.inbound-tourism-by-month');
    }
}
