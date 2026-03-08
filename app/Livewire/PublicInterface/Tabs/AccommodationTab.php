<?php

namespace App\Livewire\PublicInterface\Tabs;

use App\Models\Accommodation;
use App\Models\AccommodationPerformance;
use App\Models\Month;
use App\Models\Year;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class AccommodationTab extends Component
{
    public ?int $year = null;
    public ?int $month = null;

    public array $kpis = [];
    public array $occupancyByMonth = [];
    public array $occupancyYoYByMonth = [];
    public array $seasonVsOccupancy = [];
    public array $byCategory = [];
    public array $installedCapacityByDepartment = [];
    public array $installedCapacityByMonth = [];
    public array $availableRoomsByMonth = [];

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
        $this->occupancyByMonth = $this->loadOccupancyByMonth();
        $this->occupancyYoYByMonth = $this->loadOccupancyYoYByMonth();
        $this->seasonVsOccupancy = $this->loadSeasonVsOccupancy();
        $this->byCategory = $this->loadByCategory();
        $this->installedCapacityByDepartment = $this->loadInstalledCapacityByDepartment();
        $this->installedCapacityByMonth = $this->loadInstalledCapacityByMonth();
        $this->availableRoomsByMonth = $this->loadAvailableRoomsByMonth();
    }

    private function cacheKey(string $suffix): string
    {
        return "public_accommodation_tab:{$suffix}:year_{$this->year}:month_" . ($this->month ?? 'all');
    }

    private function performanceQuery()
    {
        return AccommodationPerformance::query()
            ->when($this->year, fn ($query) => $query->where('year_id', $this->year))
            ->when($this->month, fn ($query) => $query->where('month_id', $this->month));
    }

    private function loadKpis(): array
    {
        return Cache::remember($this->cacheKey('kpis'), now()->addMinutes(10), function () {
            $establishments = (int) Accommodation::query()->sum('establishments');
            $rooms = (int) Accommodation::query()->sum('rooms');
            $beds = (int) Accommodation::query()->sum('beds');

            $occupancyAverage = round(
                (float) (($this->performanceQuery()->avg('occupancy_rate')) ?? 0),
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

    /**
     * Serie mensual de ocupación.
     */
    private function loadOccupancyByMonth(): array
    {
        return Cache::remember(
            "public_accommodation_tab:occupancy_by_month:year_{$this->year}",
            now()->addMinutes(10),
            function () {
                if (! $this->year) {
                    return ['labels' => [], 'data' => []];
                }

                $months = Month::query()
                    ->orderBy('month_number')
                    ->get(['id', 'month']);

                $rows = AccommodationPerformance::query()
                    ->where('year_id', $this->year)
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

    /**
     * Comparación interanual de ocupación mensual.
     */
    private function loadOccupancyYoYByMonth(): array
    {
        return Cache::remember(
            "public_accommodation_tab:occupancy_yoy_by_month:year_{$this->year}",
            now()->addMinutes(10),
            function () {
                if (! $this->year) {
                    return [
                        'labels' => [],
                        'current' => [],
                        'previous' => [],
                        'current_year' => null,
                        'previous_year' => null,
                    ];
                }

                $selectedYearValue = (int) Year::whereKey($this->year)->value('year');
                $previousYearId = Year::query()->where('year', $selectedYearValue - 1)->value('id');

                $months = Month::query()
                    ->orderBy('month_number')
                    ->get(['id', 'month']);

                $current = AccommodationPerformance::query()
                    ->where('year_id', $this->year)
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

    /**
     * Ocupación por temporada.
     */
    private function loadSeasonVsOccupancy(): array
    {
        return Cache::remember($this->cacheKey('season_vs_occupancy'), now()->addMinutes(10), function () {
            $rows = $this->performanceQuery()
                ->selectRaw('COALESCE(season, "Sin temporada") as season_label, AVG(occupancy_rate) as avg_occupancy')
                ->groupBy('season_label')
                ->orderBy('season_label')
                ->get();

            return [
                'labels' => $rows->pluck('season_label')->toArray(),
                'data' => $rows->pluck('avg_occupancy')->map(fn ($value) => round((float) $value, 2))->toArray(),
            ];
        });
    }

    /**
     * Capacidad instalada por categoría.
     */
    private function loadByCategory(): array
    {
        return Cache::remember('public_accommodation_tab:by_category', now()->addMinutes(10), function () {
            $rows = Accommodation::query()
                ->leftJoin('accommodation_categories', 'accommodation_categories.id', '=', 'accommodations.accommodation_category_id')
                ->selectRaw('COALESCE(accommodation_categories.description, "Sin categoría") as category, SUM(accommodations.establishments) as total')
                ->groupBy('category')
                ->orderByDesc('total')
                ->get();

            return [
                'labels' => $rows->pluck('category')->toArray(),
                'data' => $rows->pluck('total')->map(fn ($value) => (int) $value)->toArray(),
            ];
        });
    }

    /**
     * Capacidad instalada por departamento.
     */
    private function loadInstalledCapacityByDepartment(): array
    {
        return Cache::remember('public_accommodation_tab:installed_capacity_by_department', now()->addMinutes(10), function () {
            $rows = Accommodation::query()
                ->leftJoin('states', 'states.id', '=', 'accommodations.state_id')
                ->selectRaw('COALESCE(states.description, "Sin departamento") as department, SUM(accommodations.beds) as total')
                ->groupBy('department')
                ->orderByDesc('total')
                ->get();

            return [
                'labels' => $rows->pluck('department')->toArray(),
                'data' => $rows->pluck('total')->map(fn ($value) => (int) $value)->toArray(),
            ];
        });
    }

    /**
     * Serie mensual de capacidad instalada.
     * Como la tabla base de capacidad no es mensual, repetimos el total como referencia anual.
     */
    private function loadInstalledCapacityByMonth(): array
    {
        return Cache::remember(
            "public_accommodation_tab:installed_capacity_by_month:year_{$this->year}",
            now()->addMinutes(10),
            function () {
                if (! $this->year) {
                    return ['labels' => [], 'data' => []];
                }

                $months = Month::query()
                    ->orderBy('month_number')
                    ->get(['id', 'month']);

                $totalBeds = (int) Accommodation::query()->sum('beds');

                return [
                    'labels' => $months->pluck('month')->toArray(),
                    'data' => $months->map(fn () => $totalBeds)->toArray(),
                ];
            }
        );
    }

    /**
     * Serie mensual de habitaciones disponibles.
     * Si no existe un campo mensual específico, usamos rooms como referencia instalada.
     */
    private function loadAvailableRoomsByMonth(): array
    {
        return Cache::remember(
            "public_accommodation_tab:available_rooms_by_month:year_{$this->year}",
            now()->addMinutes(10),
            function () {
                if (! $this->year) {
                    return ['labels' => [], 'data' => []];
                }

                $months = Month::query()
                    ->orderBy('month_number')
                    ->get(['id', 'month']);

                $totalRooms = (int) Accommodation::query()->sum('rooms');

                return [
                    'labels' => $months->pluck('month')->toArray(),
                    'data' => $months->map(fn () => $totalRooms)->toArray(),
                ];
            }
        );
    }

    public function render()
    {
        return view('livewire.public-interface.tabs.accommodation-tab');
    }
}
