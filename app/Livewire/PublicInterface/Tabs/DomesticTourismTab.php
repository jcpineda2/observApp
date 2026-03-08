<?php

namespace App\Livewire\PublicInterface\Tabs;

use App\Enums\IndicatorDomain;
use App\Enums\IndicatorKey;
use App\Models\DomesticTourism;
use App\Models\IndicatorConstant;
use App\Models\Month;
use App\Models\Year;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class DomesticTourismTab extends Component
{
    public ?int $year = null;
    public ?int $month = null;

    public array $kpis = [];
    public array $fixedComposition = [];

    public array $touristsByMonth = [];
    public array $spendObservedByMonth = [];
    public array $averageStayObservedByMonth = [];
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
        $this->fixedComposition = $this->loadFixedComposition();

        $this->touristsByMonth = $this->loadTouristsByMonth();
        $this->spendObservedByMonth = $this->loadSpendObservedByMonth();
        $this->averageStayObservedByMonth = $this->loadAverageStayObservedByMonth();
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

            $fixedAvgSpend = $this->resolveConstant(IndicatorKey::AvgSpendFixed);
            $fixedAvgStay = $this->resolveConstant(IndicatorKey::AvgStayFixed);

            return [
                'tourists' => (int) (clone $query)->sum('tourist_quantity'),
                'fixed_avg_spend' => $fixedAvgSpend?->value,
                'fixed_avg_spend_unit' => $fixedAvgSpend?->unit,
                'fixed_avg_spend_source' => $fixedAvgSpend?->source,
                'fixed_avg_stay' => $fixedAvgStay?->value,
                'fixed_avg_stay_unit' => $fixedAvgStay?->unit,
                'fixed_avg_stay_source' => $fixedAvgStay?->source,
            ];
        });
    }

    private function loadFixedComposition(): array
    {
        return Cache::remember("public_domestic_tab:fixed_composition:year_{$this->year}", now()->addMinutes(10), function () {
            $rows = [
                IndicatorKey::ExpenseCompositionFood,
                IndicatorKey::ExpenseCompositionLodging,
                IndicatorKey::ExpenseCompositionTransport,
                IndicatorKey::ExpenseCompositionShopping,
                IndicatorKey::ExpenseCompositionOther,
            ];

            $items = collect($rows)->map(function (IndicatorKey $key) {
                $constant = $this->resolveConstant($key);

                return [
                    'key' => $key->value,
                    'label' => $key->getLabel(),
                    'value' => $constant?->value ?? 0,
                    'unit' => $constant?->unit,
                    'source' => $constant?->source,
                ];
            });

            return [
                'labels' => $items->pluck('label')->toArray(),
                'data' => $items->pluck('value')->map(fn ($value) => round((float) $value, 2))->toArray(),
                'items' => $items->toArray(),
            ];
        });
    }

    /**
     * Serie mensual de turistas.
     * Ignora el filtro de mes para mostrar el año completo.
     */
    private function loadTouristsByMonth(): array
    {
        return Cache::remember(
            "public_domestic_tab:tourists_by_month:year_{$this->year}",
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

    private function loadSpendObservedByMonth(): array
    {
        return Cache::remember(
            "public_domestic_tab:spend_observed_by_month:year_{$this->year}",
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

    private function loadAverageStayObservedByMonth(): array
    {
        return Cache::remember(
            "public_domestic_tab:average_stay_observed_by_month:year_{$this->year}",
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
                    ->selectRaw('month_id, AVG(average_stay) as avg_stay')
                    ->groupBy('month_id')
                    ->pluck('avg_stay', 'month_id');

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
                ->leftJoin('origin_regions', 'origin_regions.id', '=', 'domestic_tourisms.origin_region_id')
                ->selectRaw('COALESCE(origin_regions.name, "Sin región") as region, SUM(domestic_tourisms.tourist_quantity) as total')
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

    private function resolveConstant(IndicatorKey $key): ?object
    {
        if (! $this->year) {
            return null;
        }

        $row = IndicatorConstant::query()
            ->where('domain', IndicatorDomain::Domestic->value)
            ->where('key', $key->value)
            ->where(function ($query) {
                $query->where('year_id', $this->year)
                    ->orWhereNull('year_id');
            })
            ->orderByRaw('CASE WHEN year_id = ? THEN 0 ELSE 1 END', [$this->year])
            ->first();

        if (! $row) {
            return null;
        }

        return (object) [
            'value' => (float) $row->value,
            'unit' => $row->unit,
            'source' => $row->source,
        ];
    }

    public function render()
    {
        return view('livewire.public-interface.tabs.domestic-tourism-tab');
    }
}
