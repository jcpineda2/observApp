<?php

namespace App\Livewire\PublicInterface\Tabs;

use App\Models\DomesticTourism;
use App\Models\Month;
use App\Models\Year;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class DomesticTourismTab extends Component
{
    public ?int $year = null;
    public ?int $month = null;

    public array $kpis = [];
    public array $byMonth = [];
    public array $spendByMonth = [];
    public array $avgStayByMonth = [];
    public array $byDestinationDepartment = [];
    public array $byOriginRegion = [];
    public array $byTravelReason = [];

    protected $listeners = [
        'public-filters-updated' => 'onFiltersUpdated',
    ];

    public function mount(): void
    {
        if (! $this->year) {
            $this->year = Year::query()
                ->orderByDesc('year')
                ->value('id');
        }

        $this->loadAll();
    }

    public function onFiltersUpdated($year, $month): void
    {
        $this->year = $year ?: null;
        $this->month = $month ?: null;

        $this->loadAll();
    }

    private function loadAll(): void
    {
        $this->kpis = $this->loadKpis();
        $this->byMonth = $this->loadByMonth();
        $this->spendByMonth = $this->loadSpendByMonth();
        $this->avgStayByMonth = $this->loadAverageStayByMonth();
        $this->byDestinationDepartment = $this->loadByDestinationDepartment();
        $this->byOriginRegion = $this->loadByOriginRegion();
        $this->byTravelReason = $this->loadByTravelReason();
    }

    private function cacheKey(string $suffix): string
    {
        return "public_domestic_tab:{$suffix}:year_{$this->year}:month_" . ($this->month ?? 'all');
    }

    private function baseQuery()
    {
        return DomesticTourism::query()
            ->when($this->year, fn ($query) => $query->where('year_id', $this->year))
            ->when($this->month, fn ($query) => $query->where('month_id', $this->month));
    }

    private function loadKpis(): array
    {
        return Cache::remember($this->cacheKey('kpis'), now()->addMinutes(10), function () {
            $query = $this->baseQuery();

            return [
                'tourists' => (int) (clone $query)->sum('tourist_quantity'),
                'total_spend_observed' => round((float) ((clone $query)->sum('total_spend') ?? 0), 2),
                'average_stay_observed' => round((float) ((clone $query)->avg('average_stay') ?? 0), 2),
            ];
        });
    }

    /**
     * Apertura mensual: ignora el filtro de mes para mostrar todos los meses del año.
     */
    private function loadByMonth(): array
    {
        return Cache::remember(
            "public_domestic_tab:by_month:year_{$this->year}",
            now()->addMinutes(10),
            function () {
                if (! $this->year) {
                    return ['labels' => [], 'data' => []];
                }

                $months = Month::query()
                    ->orderBy('month_number')
                    ->get(['id', 'month']);

                $rows = DomesticTourism::query()
                    ->where('year_id', $this->year)
                    ->selectRaw('month_id, SUM(tourist_quantity) as total')
                    ->groupBy('month_id')
                    ->pluck('total', 'month_id');

                return [
                    'labels' => $months->pluck('month')->toArray(),
                    'data' => $months->map(fn ($month) => (int) ($rows[$month->id] ?? 0))->toArray(),
                ];
            }
        );
    }

    /**
     * Apertura mensual de gasto: ignora el filtro de mes para mostrar la serie anual completa.
     */
    private function loadSpendByMonth(): array
    {
        return Cache::remember(
            "public_domestic_tab:spend_by_month:year_{$this->year}",
            now()->addMinutes(10),
            function () {
                if (! $this->year) {
                    return ['labels' => [], 'data' => []];
                }

                $months = Month::query()
                    ->orderBy('month_number')
                    ->get(['id', 'month']);

                $rows = DomesticTourism::query()
                    ->where('year_id', $this->year)
                    ->selectRaw('month_id, SUM(total_spend) as total')
                    ->groupBy('month_id')
                    ->pluck('total', 'month_id');

                return [
                    'labels' => $months->pluck('month')->toArray(),
                    'data' => $months->map(fn ($month) => round((float) ($rows[$month->id] ?? 0), 2))->toArray(),
                ];
            }
        );
    }

    /**
     * Apertura mensual de estadía promedio: ignora el filtro de mes para mostrar la serie anual completa.
     */
    private function loadAverageStayByMonth(): array
    {
        return Cache::remember(
            "public_domestic_tab:avg_stay_by_month:year_{$this->year}",
            now()->addMinutes(10),
            function () {
                if (! $this->year) {
                    return ['labels' => [], 'data' => []];
                }

                $months = Month::query()
                    ->orderBy('month_number')
                    ->get(['id', 'month']);

                $rows = DomesticTourism::query()
                    ->where('year_id', $this->year)
                    ->selectRaw('month_id, AVG(average_stay) as avg_value')
                    ->groupBy('month_id')
                    ->pluck('avg_value', 'month_id');

                return [
                    'labels' => $months->pluck('month')->toArray(),
                    'data' => $months->map(fn ($month) => round((float) ($rows[$month->id] ?? 0), 2))->toArray(),
                ];
            }
        );
    }

    private function loadByDestinationDepartment(): array
    {
        return Cache::remember($this->cacheKey('by_destination_department'), now()->addMinutes(10), function () {
            $rows = $this->baseQuery()
                ->leftJoin('states', 'states.id', '=', 'domestic_tourisms.destination_department_id')
                ->selectRaw('COALESCE(states.name, "Sin departamento") as department, SUM(domestic_tourisms.tourist_quantity) as total')
                ->groupBy('department')
                ->orderByDesc('total')
                ->limit(10)
                ->get();

            return [
                'labels' => $rows->pluck('department')->toArray(),
                'data' => $rows->pluck('total')->map(fn ($value) => (int) $value)->toArray(),
            ];
        });
    }

    private function loadByOriginRegion(): array
    {
        return Cache::remember($this->cacheKey('by_origin_region'), now()->addMinutes(10), function () {
            $rows = $this->baseQuery()
                ->selectRaw('COALESCE(origin_region, "Sin región") as region, SUM(tourist_quantity) as total')
                ->groupBy('region')
                ->orderByDesc('total')
                ->get();

            return [
                'labels' => $rows->pluck('region')->toArray(),
                'data' => $rows->pluck('total')->map(fn ($value) => (int) $value)->toArray(),
            ];
        });
    }

    private function loadByTravelReason(): array
    {
        return Cache::remember($this->cacheKey('by_travel_reason'), now()->addMinutes(10), function () {
            $rows = $this->baseQuery()
                ->leftJoin('travel_reasons', 'travel_reasons.id', '=', 'domestic_tourisms.travel_reason_id')
                ->selectRaw('COALESCE(travel_reasons.description, "Sin motivo") as travel_reason, SUM(domestic_tourisms.tourist_quantity) as total')
                ->groupBy('travel_reason')
                ->orderByDesc('total')
                ->get();

            return [
                'labels' => $rows->pluck('travel_reason')->toArray(),
                'data' => $rows->pluck('total')->map(fn ($value) => (int) $value)->toArray(),
            ];
        });
    }

    public function render()
    {
        return view('livewire.public-interface.tabs.domestic-tourism-tab');
    }
}
