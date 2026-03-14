<?php

namespace App\Livewire\Public;

use App\Enums\Scope;
use App\Models\AirConnectivityRoute;
use App\Models\Airport;
use App\Models\Month;
use App\Models\Year;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.public')]

class ConnectivityPage extends Component
{
    public ?int $year = null;
    public ?int $month = null;

    public array $kpis = [];
    public array $flightsSeatsByMonth = [];
    public array $topAirlinesBySeats = [];
    public array $topRoutes = [];
    public array $topOriginAirports = [];
    public array $topDestinationAirports = [];
    public array $destinationsByCountry = [];
    public array $destinationsByCity = [];

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
        $this->flightsSeatsByMonth = $this->loadFlightsSeatsByMonth();
        $this->topAirlinesBySeats = $this->loadTopAirlinesBySeats();
        $this->topRoutes = $this->loadTopRoutes();
        $this->topOriginAirports = $this->loadTopOriginAirports();
        $this->topDestinationAirports = $this->loadTopDestinationAirports();
        $this->destinationsByCountry = $this->loadDestinationsByCountry();
        $this->destinationsByCity = $this->loadDestinationsByCity();
    }

    private function cacheKey(string $suffix): string
    {
        return "public_connectivity_tab:{$suffix}:year_{$this->year}:month_" . ($this->month ?? 'all');
    }

    private function routesQuery()
    {
        return AirConnectivityRoute::query()
            ->when($this->year, fn ($query) => $query->where('year_id', $this->year))
            ->when($this->month, fn ($query) => $query->where('month_id', $this->month));
    }

    private function loadKpis(): array
    {
        return Cache::remember($this->cacheKey('kpis'), now()->addMinutes(10), function () {
            $operationalAirports = (int) Airport::query()
                ->where('is_operational', true)
                ->count();

            $nationalAirports = (int) Airport::query()
                ->where('is_operational', true)
                ->where('scope', Scope::NATIONAL->value)
                ->count();

            $internationalAirports = (int) Airport::query()
                ->where('is_operational', true)
                ->where('scope', Scope::INTERNATIONAL->value)
                ->count();

            $activeRoutes = (int) (clone $this->routesQuery())
                ->where('is_active', true)
                ->count();

            $connectedDestinations = (int) (clone $this->routesQuery())
                ->distinct('destination_airport_id')
                ->count('destination_airport_id');

            return [
                'operational_airports' => $operationalAirports,
                'national_airports' => $nationalAirports,
                'international_airports' => $internationalAirports,
                'active_routes' => $activeRoutes,
                'connected_destinations' => $connectedDestinations,
            ];
        });
    }

    /**
     * Serie mensual de vuelos y asientos.
     * Ignora el filtro de mes para mostrar el año completo.
     */
    private function loadFlightsSeatsByMonth(): array
    {
        return Cache::remember(
            "public_connectivity_tab:flights_seats_by_month:year_{$this->year}",
            now()->addMinutes(10),
            function () {
                if (! $this->year) {
                    return [
                        'labels' => [],
                        'flights' => [],
                        'seats' => [],
                    ];
                }

                $months = Month::query()
                    ->orderBy('month_number')
                    ->get(['id', 'month']);

                $rows = AirConnectivityRoute::query()
                    ->where('year_id', $this->year)
                    ->selectRaw('month_id, SUM(flights_count) as flights_total, SUM(seats_count) as seats_total')
                    ->groupBy('month_id')
                    ->get()
                    ->keyBy('month_id');

                return [
                    'labels' => $months->pluck('month')->toArray(),
                    'flights' => $months->map(fn ($month) => (int) ($rows[$month->id]->flights_total ?? 0))->toArray(),
                    'seats' => $months->map(fn ($month) => (int) ($rows[$month->id]->seats_total ?? 0))->toArray(),
                ];
            }
        );
    }

    private function loadTopAirlinesBySeats(): array
    {
        return Cache::remember($this->cacheKey('top_airlines_by_seats'), now()->addMinutes(10), function () {
            $rows = $this->routesQuery()
                ->leftJoin('air_lines', 'air_lines.id', '=', 'air_connectivity_routes.air_line_id')
                ->selectRaw('COALESCE(air_lines.name, "Sin aerolínea") as air_line, SUM(air_connectivity_routes.seats_count) as total')
                ->groupBy('air_line')
                ->orderByDesc('total')
                ->limit(10)
                ->get();

            return [
                'labels' => $rows->pluck('air_line')->toArray(),
                'data' => $rows->pluck('total')->map(fn ($value) => (int) $value)->toArray(),
            ];
        });
    }

    private function loadTopRoutes(): array
    {
        return Cache::remember($this->cacheKey('top_routes'), now()->addMinutes(10), function () {
            $rows = $this->routesQuery()
                ->leftJoin('airports as origin_airports', 'origin_airports.id', '=', 'air_connectivity_routes.origin_airport_id')
                ->leftJoin('airports as destination_airports', 'destination_airports.id', '=', 'air_connectivity_routes.destination_airport_id')
                ->selectRaw('CONCAT(COALESCE(origin_airports.name, "Origen"), " → ", COALESCE(destination_airports.name, "Destino")) as route_label, SUM(air_connectivity_routes.seats_count) as total_seats, SUM(air_connectivity_routes.flights_count) as total_flights')
                ->groupBy('route_label')
                ->orderByDesc('total_seats')
                ->limit(10)
                ->get();

            return $rows->map(fn ($row) => [
                'route' => $row->route_label,
                'seats' => (int) $row->total_seats,
                'flights' => (int) $row->total_flights,
            ])->toArray();
        });
    }

    private function loadTopOriginAirports(): array
    {
        return Cache::remember($this->cacheKey('top_origin_airports'), now()->addMinutes(10), function () {
            $rows = $this->routesQuery()
                ->leftJoin('airports', 'airports.id', '=', 'air_connectivity_routes.origin_airport_id')
                ->selectRaw('COALESCE(airports.name, "Sin origen") as airport, SUM(air_connectivity_routes.seats_count) as total')
                ->groupBy('airport')
                ->orderByDesc('total')
                ->limit(10)
                ->get();

            return [
                'labels' => $rows->pluck('airport')->toArray(),
                'data' => $rows->pluck('total')->map(fn ($value) => (int) $value)->toArray(),
            ];
        });
    }

    private function loadTopDestinationAirports(): array
    {
        return Cache::remember($this->cacheKey('top_destination_airports'), now()->addMinutes(10), function () {
            $rows = $this->routesQuery()
                ->leftJoin('airports', 'airports.id', '=', 'air_connectivity_routes.destination_airport_id')
                ->selectRaw('COALESCE(airports.name, "Sin destino") as airport, SUM(air_connectivity_routes.seats_count) as total')
                ->groupBy('airport')
                ->orderByDesc('total')
                ->limit(10)
                ->get();

            return [
                'labels' => $rows->pluck('airport')->toArray(),
                'data' => $rows->pluck('total')->map(fn ($value) => (int) $value)->toArray(),
            ];
        });
    }

    private function loadDestinationsByCountry(): array
    {
        return Cache::remember($this->cacheKey('destinations_by_country'), now()->addMinutes(10), function () {
            $rows = $this->routesQuery()
                ->leftJoin('airports', 'airports.id', '=', 'air_connectivity_routes.destination_airport_id')
                ->leftJoin('countries', 'countries.id', '=', 'airports.country_id')
                ->selectRaw('COALESCE(countries.name, "Sin país") as country, COUNT(DISTINCT air_connectivity_routes.destination_airport_id) as total')
                ->groupBy('country')
                ->orderByDesc('total')
                ->get();

            return [
                'labels' => $rows->pluck('country')->toArray(),
                'data' => $rows->pluck('total')->map(fn ($value) => (int) $value)->toArray(),
            ];
        });
    }

    private function loadDestinationsByCity(): array
    {
        return Cache::remember($this->cacheKey('destinations_by_city'), now()->addMinutes(10), function () {
            $rows = $this->routesQuery()
                ->leftJoin('airports', 'airports.id', '=', 'air_connectivity_routes.destination_airport_id')
                ->leftJoin('cities', 'cities.id', '=', 'airports.city_id')
                ->selectRaw('COALESCE(cities.name, "Sin ciudad") as city, COUNT(DISTINCT air_connectivity_routes.destination_airport_id) as total')
                ->groupBy('city')
                ->orderByDesc('total')
                ->limit(10)
                ->get();

            return [
                'labels' => $rows->pluck('city')->toArray(),
                'data' => $rows->pluck('total')->map(fn ($value) => (int) $value)->toArray(),
            ];
        });
    }

    public function render()
    {
        return view('livewire.public.connectivity-page');
    }
}
