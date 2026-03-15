<?php

namespace App\Actions\Public;

use App\Data\Public\FiltersData;
use App\Data\Public\ProvidersDashboardData;
use App\Models\Month;
use App\Models\TourismProviderStat;
use App\Models\Year;
use App\Support\Public\ProvidersQuery;
use Illuminate\Support\Facades\Cache;

final class GetProvidersDashboard
{
    public function __construct(
        private readonly ProvidersQuery $query,
    ) {}

    public function handle(FiltersData $filters): ProvidersDashboardData
    {
        return new ProvidersDashboardData(
            kpis: $this->loadKpis($filters),
            registrationsCancellationsByMonth: $this->loadRegistrationsCancellationsByMonth($filters),
            yoyStockByMonth: $this->loadYoYStockByMonth($filters),
            formalizationByMonth: $this->loadFormalizationByMonth($filters),
            byServiceSector: $this->loadByServiceSector($filters),
            byDepartment: $this->loadByDepartment($filters),
        );
    }

    private function cacheKey(FiltersData $filters, string $suffix): string
    {
        return 'public_providers_tab:' . $suffix . ':' . $filters->cacheSuffix();
    }

    private function yearCacheKey(?int $year, string $suffix): string
    {
        return 'public_providers_tab:' . $suffix . ':year_' . ($year ?? 'all');
    }

    private function loadKpis(FiltersData $filters): array
    {
        return Cache::remember($this->cacheKey($filters, 'kpis'), now()->addMinutes(10), function () use ($filters) {
            $query = $this->query->base($filters);

            $totalRegistered = (int) (clone $query)->sum('total_registered');
            $registrations = (int) (clone $query)->sum('registrations');
            $cancellations = (int) (clone $query)->sum('cancellations');
            $formalizedTotal = (int) (clone $query)->sum('formalized_total');

            $formalizationRate = $totalRegistered > 0
                ? round(($formalizedTotal / $totalRegistered) * 100, 2)
                : 0.0;

            return [
                'total_registered' => $totalRegistered,
                'registrations' => $registrations,
                'cancellations' => $cancellations,
                'formalization_rate' => $formalizationRate,
            ];
        });
    }

    /**
     * Serie mensual: ignora el filtro de mes para mostrar todo el año.
     */
    private function loadRegistrationsCancellationsByMonth(FiltersData $filters): array
    {
        return Cache::remember(
            $this->yearCacheKey($filters->year, 'registrations_cancellations_by_month'),
            now()->addMinutes(10),
            function () use ($filters) {
                if (! $filters->year) {
                    return [
                        'labels' => [],
                        'registrations' => [],
                        'cancellations' => [],
                    ];
                }

                $months = Month::query()
                    ->orderBy('month_number')
                    ->get(['id', 'month']);

                $rows = TourismProviderStat::query()
                    ->where('year_id', $filters->year)
                    ->selectRaw('month_id, SUM(registrations) as registrations_total, SUM(cancellations) as cancellations_total')
                    ->groupBy('month_id')
                    ->get()
                    ->keyBy('month_id');

                return [
                    'labels' => $months->pluck('month')->toArray(),
                    'registrations' => $months->map(fn ($month) => (int) ($rows[$month->id]->registrations_total ?? 0))->toArray(),
                    'cancellations' => $months->map(fn ($month) => (int) ($rows[$month->id]->cancellations_total ?? 0))->toArray(),
                ];
            }
        );
    }

    /**
     * Variación interanual del stock total por mes.
     */
    private function loadYoYStockByMonth(FiltersData $filters): array
    {
        return Cache::remember(
            $this->yearCacheKey($filters->year, 'yoy_stock_by_month'),
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

                $current = TourismProviderStat::query()
                    ->where('year_id', $filters->year)
                    ->selectRaw('month_id, SUM(total_registered) as total')
                    ->groupBy('month_id')
                    ->pluck('total', 'month_id');

                $previous = collect();

                if ($previousYearId) {
                    $previous = TourismProviderStat::query()
                        ->where('year_id', $previousYearId)
                        ->selectRaw('month_id, SUM(total_registered) as total')
                        ->groupBy('month_id')
                        ->pluck('total', 'month_id');
                }

                return [
                    'labels' => $months->pluck('month')->toArray(),
                    'current' => $months->map(fn ($month) => (int) ($current[$month->id] ?? 0))->toArray(),
                    'previous' => $months->map(fn ($month) => (int) ($previous[$month->id] ?? 0))->toArray(),
                    'current_year' => $selectedYearValue,
                    'previous_year' => $selectedYearValue - 1,
                ];
            }
        );
    }

    /**
     * Formalización mensual (%).
     */
    private function loadFormalizationByMonth(FiltersData $filters): array
    {
        return Cache::remember(
            $this->yearCacheKey($filters->year, 'formalization_by_month'),
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

                $rows = TourismProviderStat::query()
                    ->where('year_id', $filters->year)
                    ->selectRaw('month_id, SUM(total_registered) as total_registered_sum, SUM(formalized_total) as formalized_sum')
                    ->groupBy('month_id')
                    ->get()
                    ->keyBy('month_id');

                return [
                    'labels' => $months->pluck('month')->toArray(),
                    'data' => $months->map(function ($month) use ($rows) {
                        $row = $rows[$month->id] ?? null;
                        $total = (int) ($row->total_registered_sum ?? 0);
                        $formalized = (int) ($row->formalized_sum ?? 0);

                        return $total > 0
                            ? round(($formalized / $total) * 100, 2)
                            : 0;
                    })->toArray(),
                ];
            }
        );
    }

    private function loadByServiceSector(FiltersData $filters): array
    {
        return Cache::remember($this->cacheKey($filters, 'by_service_sector'), now()->addMinutes(10), function () use ($filters) {
            $rows = $this->query->base($filters)
                ->leftJoin('service_sectors', 'service_sectors.id', '=', 'tourism_provider_stats.service_sector_id')
                ->selectRaw('COALESCE(service_sectors.description, "Sin rubro") as sector, SUM(tourism_provider_stats.total_registered) as total')
                ->groupBy('sector')
                ->orderByDesc('total')
                ->get();

            return [
                'labels' => $rows->pluck('sector')->toArray(),
                'data' => $rows->pluck('total')->map(fn ($value) => (int) $value)->toArray(),
            ];
        });
    }

    private function loadByDepartment(FiltersData $filters): array
    {
        return Cache::remember($this->cacheKey($filters, 'by_department'), now()->addMinutes(10), function () use ($filters) {
            $rows = $this->query->base($filters)
                ->leftJoin('states', 'states.id', '=', 'tourism_provider_stats.state_id')
                ->selectRaw('COALESCE(states.name, "Sin departamento") as department, SUM(tourism_provider_stats.total_registered) as total')
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
