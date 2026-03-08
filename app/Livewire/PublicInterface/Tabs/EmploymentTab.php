<?php

namespace App\Livewire\PublicInterface\Tabs;

use App\Enums\Gender;
use App\Models\EmploymentDemographic;
use App\Models\TourismEmployment;
use App\Models\Year;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class EmploymentTab extends Component
{
    public ?int $year = null;

    public array $kpis = [];
    public array $byServiceSector = [];
    public array $trend = [];
    public array $yoyTrend = [];
    public array $byGender = [];
    public array $byAge = [];
    public array $genderByServiceSector = [];

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

        // En empleo no usamos filtro de mes.
        $this->loadAll();
    }

    private function loadAll(): void
    {
        $this->kpis = $this->loadKpis();
        $this->byServiceSector = $this->loadByServiceSector();
        $this->trend = $this->loadTrend();
        $this->yoyTrend = $this->loadYoYTrend();
        $this->byGender = $this->loadByGender();
        $this->byAge = $this->loadByAge();
        $this->genderByServiceSector = $this->loadGenderByServiceSector();
    }

    private function cacheKey(string $suffix): string
    {
        return "public_employment_tab:{$suffix}:year_" . ($this->year ?? 'all');
    }

    private function baseQuery()
    {
        return TourismEmployment::query()
            ->when($this->year, fn ($query) => $query->where('year_id', $this->year));
    }

    private function loadKpis(): array
    {
        return Cache::remember($this->cacheKey('kpis'), now()->addMinutes(10), function () {
            $query = $this->baseQuery();

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

    private function loadByServiceSector(): array
    {
        return Cache::remember($this->cacheKey('by_service_sector'), now()->addMinutes(10), function () {
            $rows = $this->baseQuery()
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
            $rows = TourismEmployment::query()
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
            $rows = TourismEmployment::query()
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

    private function loadByGender(): array
    {
        return Cache::remember($this->cacheKey('by_gender'), now()->addMinutes(10), function () {
            $rows = EmploymentDemographic::query()
                ->leftJoin('tourism_employments', 'tourism_employments.id', '=', 'employment_demographics.tourism_employment_id')
                ->when($this->year, fn ($query) => $query->where('tourism_employments.year_id', $this->year))
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

    private function loadByAge(): array
    {
        return Cache::remember($this->cacheKey('by_age'), now()->addMinutes(10), function () {
            $rows = EmploymentDemographic::query()
                ->leftJoin('tourism_employments', 'tourism_employments.id', '=', 'employment_demographics.tourism_employment_id')
                ->leftJoin('age_ranges', 'age_ranges.id', '=', 'employment_demographics.age_range_id')
                ->when($this->year, fn ($query) => $query->where('tourism_employments.year_id', $this->year))
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

    private function loadGenderByServiceSector(): array
    {
        return Cache::remember($this->cacheKey('gender_by_service_sector'), now()->addMinutes(10), function () {
            $rows = EmploymentDemographic::query()
                ->leftJoin('tourism_employments', 'tourism_employments.id', '=', 'employment_demographics.tourism_employment_id')
                ->leftJoin('service_sectors', 'service_sectors.id', '=', 'tourism_employments.service_sector_id')
                ->when($this->year, fn ($query) => $query->where('tourism_employments.year_id', $this->year))
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

    public function render()
    {
        return view('livewire.public-interface.tabs.employment-tab');
    }
}
