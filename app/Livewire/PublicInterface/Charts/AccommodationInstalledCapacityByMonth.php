<?php

namespace App\Livewire\PublicInterface\Charts;

use App\Models\Accommodation;
use App\Models\AccommodationPerformance;
use App\Models\Month;
use App\Models\Year;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Livewire\Component;

class AccommodationInstalledCapacityByMonth extends Component
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

    private function installedRoomsTotal(): int
    {
        // fallback: si no existe columna rooms, 0
        $candidates = ['rooms', 'room_count', 'rooms_count', 'total_rooms', 'rooms_total', 'cantidad_habitaciones'];

        foreach ($candidates as $col) {
            if (Schema::hasColumn('accommodations', $col)) {
                return (int) Accommodation::query()->sum($col);
            }
        }

        return 0;
    }

    private function findPerfRoomsColumn(): ?string
    {
        // columnas típicas de “habitaciones disponibles / capacidad del mes”
        $candidates = [
            'available_rooms',
            'rooms_available',
            'rooms_offered',
            'rooms_supply',
            'total_rooms_available',
        ];

        foreach ($candidates as $col) {
            if (Schema::hasColumn('accommodation_performances', $col)) {
                return $col;
            }
        }

        return null;
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

        $perfRoomsCol = $this->findPerfRoomsColumn();

        $this->labels = $this->month
            ? [($months->firstWhere('id', $this->month)?->month ?? 'Mes')]
            : $months->pluck('month')->toArray();

        // Si existe columna real en performances → usamos SUM por mes (es lo más usual para oferta)
        if ($perfRoomsCol) {
            $rows = AccommodationPerformance::query()
                ->where('year_id', $this->year)
                ->when($this->month, fn($q) => $q->where('month_id', $this->month))
                ->selectRaw("month_id, SUM($perfRoomsCol) as total_rooms")
                ->groupBy('month_id')
                ->pluck('total_rooms', 'month_id')
                ->toArray();

            $data = [];

            if ($this->month) {
                $data = [(int) ($rows[$this->month] ?? 0)];
            } else {
                foreach ($months as $m) {
                    $data[] = (int) ($rows[$m->id] ?? 0);
                }
            }

            $this->datasets = [[
                'label' => 'Habitaciones disponibles (mes)',
                'data' => $data,
                'borderWidth' => 2,
                'tension' => 0.3,
            ]];

            $this->dispatchUpdate();
            return;
        }

        // Fallback: línea constante con el total instalado (stock)
        $installed = $this->installedRoomsTotal();

        $data = $this->month
            ? [$installed]
            : array_fill(0, $months->count(), $installed);

        $this->datasets = [[
            'label' => 'Habitaciones instaladas (stock)',
            'data' => $data,
            'borderWidth' => 2,
            'tension' => 0.3,
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
        return view('livewire.public-interface.charts.accommodation-installed-capacity-by-month');
    }
}
