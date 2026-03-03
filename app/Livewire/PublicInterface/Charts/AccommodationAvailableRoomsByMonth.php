<?php

namespace App\Livewire\PublicInterface\Charts;

use App\Models\Accommodation;
use App\Models\AccommodationPerformance;
use App\Models\Month;
use App\Models\Year;
use Illuminate\Support\Str;
use Livewire\Component;

class AccommodationAvailableRoomsByMonth extends Component
{
    public ?int $year = null;
    public ?int $month = null;

    public string $chartId;
    public string $type = 'line';

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

        // 1) Promedio de ocupación por mes (AVG occupancy_rate)
        $occByMonth = AccommodationPerformance::query()
            ->where('year_id', $this->year)
            ->when($this->month, fn ($q) => $q->where('month_id', $this->month))
            ->selectRaw('month_id, AVG(occupancy_rate) as avg_occ')
            ->groupBy('month_id')
            ->pluck('avg_occ', 'month_id')
            ->toArray();

        // 2) Capacidad instalada (rooms_count) aplicada a filtros:
        //    Solo alojamientos “activos” (con performance en el año/mes)
        $activeIds = AccommodationPerformance::query()
            ->where('year_id', $this->year)
            ->when($this->month, fn ($q) => $q->where('month_id', $this->month))
            ->distinct()
            ->pluck('accommodation_id');

        $installedRooms = (int) Accommodation::query()
            ->when($activeIds->isNotEmpty(), fn ($q) => $q->whereIn('id', $activeIds))
            ->sum('rooms_count');

        // Labels + data
        if ($this->month) {
            $m = $months->firstWhere('id', $this->month);
            $this->labels = [$m?->month ?? 'Mes'];

            $occ = (float) ($occByMonth[$this->month] ?? 0);
            $occupied = round($installedRooms * ($occ / 100), 0);
            $available = max(0, $installedRooms - $occupied);

            $occupiedData = [$occupied];
            $availableData = [$available];
        } else {
            $this->labels = $months->pluck('month')->toArray();

            $occupiedData = [];
            $availableData = [];

            foreach ($months as $m) {
                $occ = (float) ($occByMonth[$m->id] ?? 0);

                $occupied = round($installedRooms * ($occ / 100), 0);
                $available = max(0, $installedRooms - $occupied);

                $occupiedData[] = $occupied;
                $availableData[] = $available;
            }
        }

        $this->datasets = [
            [
                'label' => 'Ocupadas (estimado)',
                'data' => $occupiedData,
                'borderWidth' => 2,
                'tension' => 0.3,
            ],
            [
                'label' => 'Disponibles (estimado)',
                'data' => $availableData,
                'borderWidth' => 2,
                'tension' => 0.3,
                'borderDash' => [6, 4],
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
                'animation' => false,
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
        return view('livewire.public-interface.charts.accommodation-available-rooms-by-month');
    }
}
