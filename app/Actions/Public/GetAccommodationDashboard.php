<?php

namespace App\Actions\Public;

use App\Data\Public\AccommodationDashboardData;
use App\Data\Public\FiltersData;
use App\Models\AccommodationCapacity;
use App\Models\AccommodationPerformance;
use App\Models\Month;
use App\Models\Year;
use App\Support\Public\AccommodationQuery;
use Illuminate\Support\Facades\Cache;

final class GetAccommodationDashboard
{
    public function __construct(
        private readonly AccommodationQuery $query,
    ) {}

    public function handle(FiltersData $filters): AccommodationDashboardData
    {
        return new AccommodationDashboardData(
            kpis: $this->loadKpis($filters),
            occupancyByMonth: $this->loadOccupancyByMonth($filters),
            occupancyYoYByMonth: $this->loadOccupancyYoYByMonth($filters),
            seasonVsOccupancy: $this->loadSeasonVsOccupancy($filters),
            byCategory: $this->loadByCategory(),
            capacityByDepartment: $this->loadCapacityByDepartment(),
        );
    }

    private function cacheKey(FiltersData $filters, string $suffix): string
    {
        return 'public_accommodation_tab:' . $suffix . ':' . $filters->cacheSuffix();
    }

    private function yearCacheKey(?int $year, string $suffix): string
    {
        return 'public_accommodation_tab:' . $suffix . ':year_' . ($year ?? 'all');
    }

    private function loadKpis(FiltersData $filters): array
    {
        return Cache::remember($this->cacheKey($filters, 'kpis'), now()->addMinutes(10), function () use ($filters) {
            $query = $this->query->base($filters);

            $establishments = (int) AccommodationCapacity::query()->sum('establishments_count');
            $rooms = (int) AccommodationCapacity::query()->sum('rooms_count');
            $beds = (int) AccommodationCapacity::query()->sum('beds_count');

            $occupancyAverage = round(
                (float) ((clone $query)->avg('occupancy_rate') ?? 0),
                2
            );

            return [
                'establishments' => $establishments,
                'rooms' => $rooms,
                'beds' => $beds,
                'occupancy_average' => $occupancyAverage,
            ];
        });
    }

    private function loadOccupancyByMonth(FiltersData $filters): array
    {
        return Cache::remember(
            $this->yearCacheKey($filters->year, 'occupancy_by_month'),
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

                $rows = AccommodationPerformance::query()
                    ->where('year_id', $filters->year)
                    ->selectRaw('month_id, AVG(occupancy_rate) as avg_occupancy')
                    ->groupBy('month_id')
                    ->pluck('avg_occupancy', 'month_id');

                return [
                    'labels' => $months->pluck('month')->toArray(),
                    'data' => $months->map(fn ($month) => round((float) ($rows[$month->id] ?? 0), 2))->toArray(),
                ];
            }
        );
    }

    private function loadOccupancyYoYByMonth(FiltersData $filters): array
    {
        return Cache::remember(
            $this->yearCacheKey($filters->year, 'occupancy_yoy_by_month'),
            now()->addMinutes(10),
            function () use ($filters) {
                if (! $filters->year) {
                    return [
                        'labels' => [],
                        'current' => [],
                        'previous' => [],
                        'current_year' => null,
                        'previous_year' => null,
                    ];
                }

                $selectedYearValue = (int) Year::whereKey($filters->year)->value('year');

                $previousYearId = Year::query()
                    ->where('year', $selectedYearValue - 1)
                    ->value('id');

                $months = Month::query()
                    ->orderBy('month_number')
                    ->get(['id', 'month']);

                $current = AccommodationPerformance::query()
                    ->where('year_id', $filters->year)
                    ->selectRaw('month_id, AVG(occupancy_rate) as avg_occupancy')
                    ->groupBy('month_id')
                    ->pluck('avg_occupancy', 'month_id');

                $previous = collect();

                if ($previousYearId) {
                    $previous = AccommodationPerformance::query()
                        ->where('year_id', $previousYearId)
                        ->selectRaw('month_id, AVG(occupancy_rate) as avg_occupancy')
                        ->groupBy('month_id')
                        ->pluck('avg_occupancy', 'month_id');
                }

                return [
                    'labels' => $months->pluck('month')->toArray(),
                    'current' => $months->map(fn ($month) => round((float) ($current[$month->id] ?? 0), 2))->toArray(),
                    'previous' => $months->map(fn ($month) => round((float) ($previous[$month->id] ?? 0), 2))->toArray(),
                    'current_year' => $selectedYearValue,
                    'previous_year' => $selectedYearValue - 1,
                ];
            }
        );
    }

    private function loadSeasonVsOccupancy(FiltersData $filters): array
    {
        return Cache::remember($this->cacheKey($filters, 'season_vs_occupancy'), now()->addMinutes(10), function () use ($filters) {
            $rows = $this->query->base($filters)
                ->selectRaw('season, AVG(occupancy_rate) as avg_occupancy')
                ->groupBy('season')
                ->orderBy('season')
                ->get();

            return [
                'labels' => $rows->map(fn ($row) => $row->season?->getLabel() ?? '-')->toArray(),
                'data' => $rows->pluck('avg_occupancy')->map(fn ($value) => round((float) $value, 2))->toArray(),
            ];
        });
    }

    private function loadByCategory(): array
    {
        return Cache::remember('public_accommodation_tab:by_category', now()->addMinutes(10), function () {
            $rows = AccommodationCapacity::query()
                ->leftJoin('accommodation_categories', 'accommodation_categories.id', '=', 'accommodation_capacities.accommodation_category_id')
                ->selectRaw('COALESCE(accommodation_categories.category, "Sin categoría") as category, SUM(accommodation_capacities.establishments_count) as total')
                ->groupBy('category')
                ->orderByDesc('total')
                ->get();

            return [
                'labels' => $rows->pluck('category')->toArray(),
                'data' => $rows->pluck('total')->map(fn ($value) => (int) $value)->toArray(),
            ];
        });
    }

    private function loadCapacityByDepartment(): array
    {
        return Cache::remember('public_accommodation_tab:capacity_by_department', now()->addMinutes(10), function () {
            $rows = AccommodationCapacity::query()
                ->leftJoin('states', 'states.id', '=', 'accommodation_capacities.state_id')
                ->selectRaw('COALESCE(states.name, "Sin departamento") as department, SUM(accommodation_capacities.beds_count) as total')
                ->groupBy('department')
                ->orderByDesc('total')
                ->get();

            return [
                'labels' => $rows->pluck('department')->toArray(),
                'data' => $rows->pluck('total')->map(fn ($value) => (int) $value)->toArray(),
            ];
        });
    }
}
