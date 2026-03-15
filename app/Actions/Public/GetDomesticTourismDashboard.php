<?php

namespace App\Actions\Public;

use App\Data\Public\DomesticTourismDashboardData;
use App\Data\Public\FiltersData;
use App\Enums\IndicatorDomain;
use App\Enums\IndicatorKey;
use App\Models\IndicatorConstant;
use App\Models\Month;
use App\Support\Public\DomesticTourismQuery;
use Illuminate\Support\Facades\Cache;

final class GetDomesticTourismDashboard
{
    public function __construct(
        private readonly DomesticTourismQuery $query,
    ) {}

    public function handle(FiltersData $filters): DomesticTourismDashboardData
    {
        return new DomesticTourismDashboardData(
            kpis: $this->loadKpis($filters),
            fixedComposition: $this->loadFixedComposition($filters),
            touristsByMonth: $this->loadTouristsByMonth($filters),
            spendObservedByMonth: $this->loadSpendObservedByMonth($filters),
            averageStayObservedByMonth: $this->loadAverageStayObservedByMonth($filters),
            byDestinationDepartment: $this->loadByDestinationDepartment($filters),
            byOriginRegion: $this->loadByOriginRegion($filters),
            byTravelReason: $this->loadByTravelReason($filters),
        );
    }

    private function cacheKey(FiltersData $filters, string $suffix): string
    {
        return 'public_domestic_tab:' . $suffix . ':' . $filters->cacheSuffix();
    }

    private function yearCacheKey(?int $year, string $suffix): string
    {
        return 'public_domestic_tab:' . $suffix . ':year_' . ($year ?? 'all');
    }

    private function loadKpis(FiltersData $filters): array
    {
        return Cache::remember($this->cacheKey($filters, 'kpis'), now()->addMinutes(10), function () use ($filters) {
            $query = $this->query->base($filters);

            $fixedAvgSpend = $this->resolveConstant($filters, IndicatorKey::AvgSpendFixed);
            $fixedAvgStay = $this->resolveConstant($filters, IndicatorKey::AvgStayFixed);

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

    private function loadFixedComposition(FiltersData $filters): array
    {
        return Cache::remember($this->yearCacheKey($filters->year, 'fixed_composition'), now()->addMinutes(10), function () use ($filters) {
            $rows = [
                IndicatorKey::ExpenseCompositionFood,
                IndicatorKey::ExpenseCompositionLodging,
                IndicatorKey::ExpenseCompositionTransport,
                IndicatorKey::ExpenseCompositionShopping,
                IndicatorKey::ExpenseCompositionOther,
            ];

            $items = collect($rows)->map(function (IndicatorKey $key) use ($filters) {
                $constant = $this->resolveConstant($filters, $key);

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
    private function loadTouristsByMonth(FiltersData $filters): array
    {
        return Cache::remember(
            $this->yearCacheKey($filters->year, 'tourists_by_month'),
            now()->addMinutes(10),
            function () use ($filters) {
                if (! $filters->year) {
                    return [
                        'labels' => [],
                        'data' => [],
                    ];
                }

                $months = Month::query()
                    ->orderBy('month_number')
                    ->get(['id', 'month']);

                $rows = $this->query->byYear($filters)
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

    private function loadSpendObservedByMonth(FiltersData $filters): array
    {
        return Cache::remember(
            $this->yearCacheKey($filters->year, 'spend_observed_by_month'),
            now()->addMinutes(10),
            function () use ($filters) {
                if (! $filters->year) {
                    return [
                        'labels' => [],
                        'data' => [],
                    ];
                }

                $months = Month::query()
                    ->orderBy('month_number')
                    ->get(['id', 'month']);

                $rows = $this->query->byYear($filters)
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

    private function loadAverageStayObservedByMonth(FiltersData $filters): array
    {
        return Cache::remember(
            $this->yearCacheKey($filters->year, 'average_stay_observed_by_month'),
            now()->addMinutes(10),
            function () use ($filters) {
                if (! $filters->year) {
                    return [
                        'labels' => [],
                        'data' => [],
                    ];
                }

                $months = Month::query()
                    ->orderBy('month_number')
                    ->get(['id', 'month']);

                $rows = $this->query->byYear($filters)
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

    private function loadByDestinationDepartment(FiltersData $filters): array
    {
        return Cache::remember($this->cacheKey($filters, 'by_destination_department'), now()->addMinutes(10), function () use ($filters) {
            $rows = $this->query->base($filters)
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

    private function loadByOriginRegion(FiltersData $filters): array
    {
        return Cache::remember($this->cacheKey($filters, 'by_origin_region'), now()->addMinutes(10), function () use ($filters) {
            $rows = $this->query->base($filters)
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

    private function loadByTravelReason(FiltersData $filters): array
    {
        return Cache::remember($this->cacheKey($filters, 'by_travel_reason'), now()->addMinutes(10), function () use ($filters) {
            $rows = $this->query->base($filters)
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

    private function resolveConstant(FiltersData $filters, IndicatorKey $key): ?object
    {
        if (! $filters->year) {
            return null;
        }

        $row = IndicatorConstant::query()
            ->where('domain', IndicatorDomain::Domestic->value)
            ->where('key', $key->value)
            ->where(function ($query) use ($filters) {
                $query->where('year_id', $filters->year)
                    ->orWhereNull('year_id');
            })
            ->orderByRaw('CASE WHEN year_id = ? THEN 0 ELSE 1 END', [$filters->year])
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
}
