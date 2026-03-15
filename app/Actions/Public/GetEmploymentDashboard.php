<?php

namespace App\Actions\Public;

use App\Data\Public\EmploymentDashboardData;
use App\Data\Public\FiltersData;
use App\Enums\Gender;
use App\Models\EmploymentDemographic;
use App\Support\Public\EmploymentQuery;
use Illuminate\Support\Facades\Cache;

final class GetEmploymentDashboard
{
    public function __construct(
        private readonly EmploymentQuery $query,
    ) {}

    public function handle(FiltersData $filters): EmploymentDashboardData
    {
        return new EmploymentDashboardData(
            kpis: $this->loadKpis($filters),
            byServiceSector: $this->loadByServiceSector($filters),
            trend: $this->loadTrend(),
            yoyTrend: $this->loadYoYTrend(),
            byGender: $this->loadByGender($filters),
            byAge: $this->loadByAge($filters),
            genderByServiceSector: $this->loadGenderByServiceSector($filters),
        );
    }

    private function cacheKey(FiltersData $filters, string $suffix): string
    {
        return 'public_employment_tab:' . $suffix . ':year_' . ($filters->year ?? 'all');
    }

    private function loadKpis(FiltersData $filters): array
    {
        return Cache::remember($this->cacheKey($filters, 'kpis'), now()->addMinutes(10), function () use ($filters) {
            $query = $this->query->base($filters);

            $directEmployment = (int) (clone $query)->sum('direct_employment');
            $nationalParticipation = round((float) ((clone $query)->avg('national_participation') ?? 0), 2);
            $interannualVariation = round((float) ((clone $query)->avg('interannual_variation') ?? 0), 2);
            $activeSegments = (int) (clone $query)->distinct('service_sector_id')->count('service_sector_id');

            return [
                'direct_employment' => $directEmployment,
                'national_participation' => $nationalParticipation,
                'interannual_variation' => $interannualVariation,
                'active_segments' => $activeSegments,
            ];
        });
    }

    private function loadByServiceSector(FiltersData $filters): array
    {
        return Cache::remember($this->cacheKey($filters, 'by_service_sector'), now()->addMinutes(10), function () use ($filters) {
            $rows = $this->query->base($filters)
                ->leftJoin('service_sectors', 'service_sectors.id', '=', 'tourism_employments.service_sector_id')
                ->selectRaw('COALESCE(service_sectors.description, "Sin segmento") as sector, SUM(tourism_employments.direct_employment) as total')
                ->groupBy('sector')
                ->orderByDesc('total')
                ->get();

            return [
                'labels' => $rows->pluck('sector')->toArray(),
                'data' => $rows->pluck('total')->map(fn ($value) => (int) $value)->toArray(),
            ];
        });
    }

    private function loadTrend(): array
    {
        return Cache::remember('public_employment_tab:trend', now()->addMinutes(10), function () {
            $rows = $this->query->historical()
                ->leftJoin('years', 'years.id', '=', 'tourism_employments.year_id')
                ->selectRaw('years.year as year_value, SUM(tourism_employments.direct_employment) as total')
                ->groupBy('year_value')
                ->orderBy('year_value')
                ->get();

            return [
                'labels' => $rows->pluck('year_value')->map(fn ($value) => (string) $value)->toArray(),
                'data' => $rows->pluck('total')->map(fn ($value) => (int) $value)->toArray(),
            ];
        });
    }

    private function loadYoYTrend(): array
    {
        return Cache::remember('public_employment_tab:yoy_trend', now()->addMinutes(10), function () {
            $rows = $this->query->historical()
                ->leftJoin('years', 'years.id', '=', 'tourism_employments.year_id')
                ->selectRaw('years.year as year_value, AVG(tourism_employments.interannual_variation) as avg_variation')
                ->groupBy('year_value')
                ->orderBy('year_value')
                ->get();

            return [
                'labels' => $rows->pluck('year_value')->map(fn ($value) => (string) $value)->toArray(),
                'data' => $rows->pluck('avg_variation')->map(fn ($value) => round((float) $value, 2))->toArray(),
            ];
        });
    }

    private function loadByGender(FiltersData $filters): array
    {
        return Cache::remember($this->cacheKey($filters, 'by_gender'), now()->addMinutes(10), function () use ($filters) {
            $rows = EmploymentDemographic::query()
                ->leftJoin('tourism_employments', 'tourism_employments.id', '=', 'employment_demographics.tourism_employment_id')
                ->when($filters->year, fn ($query) => $query->where('tourism_employments.year_id', $filters->year))
                ->selectRaw('employment_demographics.gender as gender, SUM(employment_demographics.people_count) as total')
                ->groupBy('employment_demographics.gender')
                ->orderBy('employment_demographics.gender')
                ->get();

            return [
                'labels' => $rows->map(fn ($row) => $row->gender?->getLabel() ?? '-')->toArray(),
                'data' => $rows->pluck('total')->map(fn ($value) => (int) $value)->toArray(),
            ];
        });
    }

    private function loadByAge(FiltersData $filters): array
    {
        return Cache::remember($this->cacheKey($filters, 'by_age'), now()->addMinutes(10), function () use ($filters) {
            $rows = EmploymentDemographic::query()
                ->leftJoin('tourism_employments', 'tourism_employments.id', '=', 'employment_demographics.tourism_employment_id')
                ->leftJoin('age_ranges', 'age_ranges.id', '=', 'employment_demographics.age_range_id')
                ->when($filters->year, fn ($query) => $query->where('tourism_employments.year_id', $filters->year))
                ->selectRaw('age_ranges.name as age_range_name, age_ranges.sort_order as sort_order, SUM(employment_demographics.people_count) as total')
                ->groupBy('age_ranges.name', 'age_ranges.sort_order')
                ->orderBy('age_ranges.sort_order')
                ->get();

            return [
                'labels' => $rows->pluck('age_range_name')->toArray(),
                'data' => $rows->pluck('total')->map(fn ($value) => (int) $value)->toArray(),
            ];
        });
    }

    private function loadGenderByServiceSector(FiltersData $filters): array
    {
        return Cache::remember($this->cacheKey($filters, 'gender_by_service_sector'), now()->addMinutes(10), function () use ($filters) {
            $rows = EmploymentDemographic::query()
                ->leftJoin('tourism_employments', 'tourism_employments.id', '=', 'employment_demographics.tourism_employment_id')
                ->leftJoin('service_sectors', 'service_sectors.id', '=', 'tourism_employments.service_sector_id')
                ->when($filters->year, fn ($query) => $query->where('tourism_employments.year_id', $filters->year))
                ->selectRaw('COALESCE(service_sectors.description, "Sin segmento") as sector, employment_demographics.gender as gender, SUM(employment_demographics.people_count) as total')
                ->groupBy('sector', 'employment_demographics.gender')
                ->orderBy('sector')
                ->get();

            $labels = $rows->pluck('sector')->unique()->values()->toArray();

            $datasets = collect(Gender::cases())->map(function ($gender) use ($rows, $labels) {
                return [
                    'label' => $gender->getLabel(),
                    'data' => collect($labels)->map(function ($sector) use ($rows, $gender) {
                        $match = $rows->first(fn ($row) => $row->sector === $sector && $row->gender === $gender);
                        return (int) ($match->total ?? 0);
                    })->toArray(),
                    'borderWidth' => 1,
                ];
            })->toArray();

            return [
                'labels' => $labels,
                'datasets' => $datasets,
            ];
        });
    }
}
