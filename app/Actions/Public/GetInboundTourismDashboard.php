<?php

namespace App\Actions\Public;

use App\Data\Public\FiltersData;
use App\Data\Public\InboundTourismDashboardData;
use App\Enums\IndicatorDomain;
use App\Enums\IndicatorKey;
use App\Models\IndicatorConstant;
use App\Models\Month;
use App\Models\Year;
use App\Support\Public\InboundTourismQuery;
use Illuminate\Support\Facades\Cache;

final class GetInboundTourismDashboard
{
    public function __construct(
        private readonly InboundTourismQuery $query,
    ) {}

    public function handle(FiltersData $filters): InboundTourismDashboardData
    {
        return new InboundTourismDashboardData(
            kpis: $this->loadKpis($filters),
            byMonth: $this->loadByMonth($filters),
            byCountry: $this->loadByCountry($filters),
            byEntryMode: $this->loadByEntryMode($filters),
            byTravelReason: $this->loadByTravelReason($filters),
            topMarkets: $this->loadTopMarkets($filters),
            yoy: $this->loadYoY($filters),
            mapByDepartment: $this->loadMapByDepartment($filters),
        );
    }

    private function cacheKey(FiltersData $filters, string $suffix): string
    {
        return 'public_inbound_tab:' . $suffix . ':' . $filters->cacheSuffix();
    }

    private function yearCacheKey(?int $year, string $suffix): string
    {
        return 'public_inbound_tab:' . $suffix . ':year_' . ($year ?? 'all');
    }

    private function loadKpis(FiltersData $filters): array
    {
        return Cache::remember($this->cacheKey($filters, 'kpis'), now()->addMinutes(10), function () use ($filters) {
            $query = $this->query->base($filters);

            $avgSpend = $this->resolveConstant($filters, IndicatorKey::AvgSpendFixed);
            $avgStay = $this->resolveConstant($filters, IndicatorKey::AvgStayFixed);

            return [
                'tourists' => (int) (clone $query)->sum('tourist_arrivals'),
                'excursionists' => (int) (clone $query)->sum('excursionist_arrivals'),
                'foreign_exchange_revenue' => round((float) ((clone $query)->sum('foreign_exchange_revenue') ?? 0), 2),
                'fixed_average_spend' => $avgSpend?->value,
                'fixed_average_spend_unit' => $avgSpend?->unit,
                'fixed_average_spend_source' => $avgSpend?->source,
                'fixed_average_stay' => $avgStay?->value,
                'fixed_average_stay_unit' => $avgStay?->unit,
                'fixed_average_stay_source' => $avgStay?->source,
            ];
        });
    }

    /**
     * Serie mensual.
     * Ignora el filtro de mes para mostrar el año completo.
     */
    private function loadByMonth(FiltersData $filters): array
    {
        return Cache::remember(
            $this->yearCacheKey($filters->year, 'by_month'),
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
                    ->selectRaw('month_id, SUM(tourist_arrivals) as total')
                    ->groupBy('month_id')
                    ->pluck('total', 'month_id');

                return [
                    'labels' => $months->pluck('month')->toArray(),
                    'data' => $months->map(fn ($month) => (int) ($rows[$month->id] ?? 0))->toArray(),
                ];
            }
        );
    }

    private function loadByCountry(FiltersData $filters): array
    {
        return Cache::remember($this->cacheKey($filters, 'by_country'), now()->addMinutes(10), function () use ($filters) {
            $rows = $this->query->base($filters)
                ->leftJoin('countries', 'countries.id', '=', 'inbound_tourisms.residence_country_id')
                ->selectRaw('COALESCE(countries.name, "Sin país") as country, SUM(inbound_tourisms.tourist_arrivals) as total')
                ->groupBy('country')
                ->orderByDesc('total')
                ->limit(10)
                ->get();

            return [
                'labels' => $rows->pluck('country')->toArray(),
                'data' => $rows->pluck('total')->map(fn ($value) => (int) $value)->toArray(),
            ];
        });
    }

    private function loadByEntryMode(FiltersData $filters): array
    {
        return Cache::remember($this->cacheKey($filters, 'by_entry_mode'), now()->addMinutes(10), function () use ($filters) {
            $rows = $this->query->base($filters)
                ->leftJoin('entry_modes', 'entry_modes.id', '=', 'inbound_tourisms.entry_mode_id')
                ->selectRaw('COALESCE(entry_modes.description, "Sin vía") as entry_mode, SUM(inbound_tourisms.tourist_arrivals) as total')
                ->groupBy('entry_mode')
                ->orderByDesc('total')
                ->get();

            return [
                'labels' => $rows->pluck('entry_mode')->toArray(),
                'data' => $rows->pluck('total')->map(fn ($value) => (int) $value)->toArray(),
            ];
        });
    }

    private function loadByTravelReason(FiltersData $filters): array
    {
        return Cache::remember($this->cacheKey($filters, 'by_travel_reason'), now()->addMinutes(10), function () use ($filters) {
            $rows = $this->query->base($filters)
                ->leftJoin('travel_reasons', 'travel_reasons.id', '=', 'inbound_tourisms.travel_reason_id')
                ->selectRaw('COALESCE(travel_reasons.description, "Sin motivo") as travel_reason, SUM(inbound_tourisms.tourist_arrivals) as total')
                ->groupBy('travel_reason')
                ->orderByDesc('total')
                ->get();

            return [
                'labels' => $rows->pluck('travel_reason')->toArray(),
                'data' => $rows->pluck('total')->map(fn ($value) => (int) $value)->toArray(),
            ];
        });
    }

    /**
     * Ranking ejecutivo de mercados emisores.
     */
    private function loadTopMarkets(FiltersData $filters): array
    {
        return Cache::remember($this->cacheKey($filters, 'top_markets'), now()->addMinutes(10), function () use ($filters) {
            $rows = $this->query->base($filters)
                ->leftJoin('countries', 'countries.id', '=', 'inbound_tourisms.residence_country_id')
                ->selectRaw('COALESCE(countries.name, "Sin país") as country, SUM(inbound_tourisms.tourist_arrivals) as total')
                ->groupBy('country')
                ->orderByDesc('total')
                ->limit(10)
                ->get();

            return [
                'labels' => $rows->pluck('country')->toArray(),
                'data' => $rows->pluck('total')->map(fn ($value) => (int) $value)->toArray(),
            ];
        });
    }

    private function loadYoY(FiltersData $filters): array
    {
        return Cache::remember(
            $this->yearCacheKey($filters->year, 'yoy'),
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

                $current = $this->query->byYear($filters)
                    ->selectRaw('month_id, SUM(tourist_arrivals) as total')
                    ->groupBy('month_id')
                    ->pluck('total', 'month_id');

                $previous = collect();

                if ($previousYearId) {
                    $previous = \App\Models\InboundTourism::query()
                        ->where('year_id', $previousYearId)
                        ->selectRaw('month_id, SUM(tourist_arrivals) as total')
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

    private function loadMapByDepartment(FiltersData $filters): array
    {
        return Cache::remember($this->cacheKey($filters, 'map_by_department'), now()->addMinutes(10), function () use ($filters) {
            $rows = $this->query->base($filters)
                ->leftJoin('states', 'states.id', '=', 'inbound_tourisms.destination_department_id')
                ->selectRaw('COALESCE(states.name, "Sin departamento") as department, SUM(inbound_tourisms.tourist_arrivals) as total')
                ->groupBy('department')
                ->get();

            return $rows
                ->mapWithKeys(function ($row) {
                    $key = $this->normalizeDepartmentKey($row->department);

                    return [$key => (int) $row->total];
                })
                ->toArray();
        });
    }

    private function normalizeDepartmentKey(?string $name): string
    {
        $normalized = mb_strtolower(trim((string) $name), 'UTF-8');

        $replacements = [
            'á' => 'a',
            'é' => 'e',
            'í' => 'i',
            'ó' => 'o',
            'ú' => 'u',
            'ü' => 'u',
            'ñ' => 'n',
            '.' => '',
            '-' => ' ',
        ];

        $normalized = strtr($normalized, $replacements);
        $normalized = preg_replace('/\s+/', ' ', $normalized);

        return match ($normalized) {
            'pdte hayes' => 'presidente hayes',
            default => $normalized,
        };
    }

    private function resolveConstant(FiltersData $filters, IndicatorKey $key): ?object
    {
        if (! $filters->year) {
            return null;
        }

        $row = IndicatorConstant::query()
            ->where('domain', IndicatorDomain::Inbound->value)
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
