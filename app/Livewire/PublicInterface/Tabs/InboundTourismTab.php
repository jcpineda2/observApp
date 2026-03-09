<?php

namespace App\Livewire\PublicInterface\Tabs;

use App\Enums\IndicatorDomain;
use App\Enums\IndicatorKey;
use App\Models\IndicatorConstant;
use App\Models\InboundTourism;
use App\Models\Month;
use App\Models\Year;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class InboundTourismTab extends Component
{
    public ?int $year = null;
    public ?int $month = null;

    public array $kpis = [];
    public array $byMonth = [];
    public array $byCountry = [];
    public array $byEntryMode = [];
    public array $byTravelReason = [];
    public array $topMarkets = [];
    public array $yoy = [];
    public array $mapByDepartment = [];

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
        $this->byCountry = $this->loadByCountry();
        $this->byEntryMode = $this->loadByEntryMode();
        $this->byTravelReason = $this->loadByTravelReason();
        $this->topMarkets = $this->loadTopMarkets();
        $this->yoy = $this->loadYoY();
        $this->mapByDepartment = $this->loadMapByDepartment();
    }

    private function cacheKey(string $suffix): string
    {
        return "public_inbound_tab:{$suffix}:year_{$this->year}:month_" . ($this->month ?? 'all');
    }

    private function baseQuery()
    {
        return InboundTourism::query()
            ->when($this->year, fn ($query) => $query->where('year_id', $this->year))
            ->when($this->month, fn ($query) => $query->where('month_id', $this->month));
    }

    private function loadKpis(): array
    {
        return Cache::remember($this->cacheKey('kpis'), now()->addMinutes(10), function () {
            $query = $this->baseQuery();

            $avgSpend = $this->resolveConstant(IndicatorKey::AvgSpendFixed);
            $avgStay = $this->resolveConstant(IndicatorKey::AvgStayFixed);

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
    private function loadByMonth(): array
    {
        return Cache::remember(
            "public_inbound_tab:by_month:year_{$this->year}",
            now()->addMinutes(10),
            function () {
                if (! $this->year) {
                    return ['labels' => [], 'data' => []];
                }

                $months = Month::query()
                    ->orderBy('month_number')
                    ->get(['id', 'month']);

                $rows = InboundTourism::query()
                    ->where('year_id', $this->year)
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

    private function loadByCountry(): array
    {
        return Cache::remember($this->cacheKey('by_country'), now()->addMinutes(10), function () {
            $rows = $this->baseQuery()
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

    private function loadByEntryMode(): array
    {
        return Cache::remember($this->cacheKey('by_entry_mode'), now()->addMinutes(10), function () {
            $rows = $this->baseQuery()
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

    private function loadByTravelReason(): array
    {
        return Cache::remember($this->cacheKey('by_travel_reason'), now()->addMinutes(10), function () {
            $rows = $this->baseQuery()
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
     * Ranking de mercados emisores.
     * Sí, se parece a byCountry, pero este bloque queda explícitamente como ranking ejecutivo.
     */
    private function loadTopMarkets(): array
    {
        return Cache::remember($this->cacheKey('top_markets'), now()->addMinutes(10), function () {
            $rows = $this->baseQuery()
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

    private function loadYoY(): array
    {
        return Cache::remember("public_inbound_tab:yoy:year_{$this->year}", now()->addMinutes(10), function () {
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
            $previousYearId = Year::query()
                ->where('year', $selectedYearValue - 1)
                ->value('id');

            $months = Month::query()
                ->orderBy('month_number')
                ->get(['id', 'month']);

            $current = InboundTourism::query()
                ->where('year_id', $this->year)
                ->selectRaw('month_id, SUM(tourist_arrivals) as total')
                ->groupBy('month_id')
                ->pluck('total', 'month_id');

            $previous = collect();

            if ($previousYearId) {
                $previous = InboundTourism::query()
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
        });
    }

    private function loadMapByDepartment(): array
    {
        return Cache::remember($this->cacheKey('map_by_department'), now()->addMinutes(10), function () {
            $rows = $this->baseQuery()
                ->leftJoin('states', 'states.id', '=', 'inbound_tourisms.destination_department_id')
                ->selectRaw('COALESCE(states.name, "Sin departamento") as department, SUM(inbound_tourisms.tourist_arrivals) as total')
                ->groupBy('department')
                ->get();

            return $rows
                ->mapWithKeys(fn ($row) => [
                    mb_strtolower(trim($row->department)) => (int) $row->total,
                ])
                ->toArray();
        });
    }

    private function resolveConstant(IndicatorKey $key): ?object
    {
        if (! $this->year) {
            return null;
        }

        $row = IndicatorConstant::query()
            ->where('domain', IndicatorDomain::Inbound->value)
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
        return view('livewire.public-interface.tabs.inbound-tourism-tab');
    }
}
