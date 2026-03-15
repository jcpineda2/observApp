<?php

namespace App\Actions\Public;

use App\Data\Public\ConnectivityDashboardData;
use App\Data\Public\FiltersData;
use App\Enums\Scope;
use App\Models\Airport;
use App\Models\Month;
use App\Support\Public\ConnectivityQuery;
use Illuminate\Support\Facades\Cache;

final class GetConnectivityDashboard
{
    public function __construct(
        private readonly ConnectivityQuery $query,
    ) {}

    public function handle(FiltersData $filters): ConnectivityDashboardData
    {
        return new ConnectivityDashboardData(
            kpis: $this->loadKpis($filters),
            flightsSeatsByMonth: $this->loadFlightsSeatsByMonth($filters),
            topAirlinesBySeats: $this->loadTopAirlinesBySeats($filters),
            topRoutes: $this->loadTopRoutes($filters),
            topOriginAirports: $this->loadTopOriginAirports($filters),
            topDestinationAirports: $this->loadTopDestinationAirports($filters),
            destinationsByCountry: $this->loadDestinationsByCountry($filters),
            destinationsByCity: $this->loadDestinationsByCity($filters),
        );
    }

    private function cacheKey(FiltersData $filters, string $suffix): string
    {
        return 'public_connectivity:' . $suffix . ':' . $filters->cacheSuffix();
    }

    private function loadKpis(FiltersData $filters): array
    {
        return Cache::remember($this->cacheKey($filters, 'kpis'), now()->addMinutes(10), function () use ($filters) {
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

            $activeRoutes = (int) $this->query->base($filters)
                ->clone()
                ->where('is_active', true)
                ->count();

            $connectedDestinations = (int) $this->query->base($filters)
                ->clone()
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

    private function loadFlightsSeatsByMonth(FiltersData $filters): array
    {
        return Cache::remember(
            'public_connectivity:flights_seats_by_month:year_' . ($filters->year ?? 'all'),
            now()->addMinutes(10),
            function () use ($filters) {
                if (! $filters->year) {
                    return [
                        'labels' => [],
                        'flights' => [],
                        'seats' => [],
                    ];
                }

                $months = Month::query()
                    ->orderBy('month_number')
                    ->get(['id', 'month']);

                $rows = $this->query->byYear($filters)
                    ->selectRaw('month_id, SUM(flights_count) as flights_total, SUM(seats_count) as seats_total')
                    ->groupBy('month_id')
                    ->get()
                    ->keyBy('month_id');

                return [
                    'labels' => $months->pluck('month')->toArray(),
                    'flights' => $months->map(fn($month) => (int) ($rows[$month->id]->flights_total ?? 0))->toArray(),
                    'seats' => $months->map(fn($month) => (int) ($rows[$month->id]->seats_total ?? 0))->toArray(),
                ];
            }
        );
    }

    private function loadTopAirlinesBySeats(FiltersData $filters): array
    {
        return Cache::remember($this->cacheKey($filters, 'top_airlines_by_seats'), now()->addMinutes(10), function () use ($filters) {
            $rows = $this->query->base($filters)
                ->leftJoin('air_lines', 'air_lines.id', '=', 'air_connectivity_routes.air_line_id')
                ->selectRaw('COALESCE(air_lines.name, "Sin aerolínea") as air_line, SUM(air_connectivity_routes.seats_count) as total')
                ->groupBy('air_line')
                ->orderByDesc('total')
                ->limit(10)
                ->get();

            return [
                'labels' => $rows->pluck('air_line')->toArray(),
                'data' => $rows->pluck('total')->map(fn($value) => (int) $value)->toArray(),
            ];
        });
    }

    private function loadTopRoutes(FiltersData $filters): array
    {
        return Cache::remember($this->cacheKey($filters, 'top_routes'), now()->addMinutes(10), function () use ($filters) {
            $rows = $this->query->base($filters)
                ->leftJoin('airports as origin_airports', 'origin_airports.id', '=', 'air_connectivity_routes.origin_airport_id')
                ->leftJoin('airports as destination_airports', 'destination_airports.id', '=', 'air_connectivity_routes.destination_airport_id')
                ->selectRaw('CONCAT(COALESCE(origin_airports.name, "Origen"), " → ", COALESCE(destination_airports.name, "Destino")) as route_label, SUM(air_connectivity_routes.seats_count) as total_seats, SUM(air_connectivity_routes.flights_count) as total_flights')
                ->groupBy('route_label')
                ->orderByDesc('total_seats')
                ->limit(10)
                ->get();

            return $rows->map(fn($row) => [
                'route' => $row->route_label,
                'seats' => (int) $row->total_seats,
                'flights' => (int) $row->total_flights,
            ])->toArray();
        });
    }

    private function loadTopOriginAirports(FiltersData $filters): array
    {
        return Cache::remember($this->cacheKey($filters, 'top_origin_airports'), now()->addMinutes(10), function () use ($filters) {
            $rows = $this->query->base($filters)
                ->leftJoin('airports', 'airports.id', '=', 'air_connectivity_routes.origin_airport_id')
                ->selectRaw('COALESCE(airports.name, "Sin origen") as airport, SUM(air_connectivity_routes.seats_count) as total')
                ->groupBy('airport')
                ->orderByDesc('total')
                ->limit(10)
                ->get();

            return [
                'labels' => $rows->pluck('airport')->toArray(),
                'data' => $rows->pluck('total')->map(fn($value) => (int) $value)->toArray(),
            ];
        });
    }

    private function loadTopDestinationAirports(FiltersData $filters): array
    {
        return Cache::remember($this->cacheKey($filters, 'top_destination_airports'), now()->addMinutes(10), function () use ($filters) {
            $rows = $this->query->base($filters)
                ->leftJoin('airports', 'airports.id', '=', 'air_connectivity_routes.destination_airport_id')
                ->selectRaw('COALESCE(airports.name, "Sin destino") as airport, SUM(air_connectivity_routes.seats_count) as total')
                ->groupBy('airport')
                ->orderByDesc('total')
                ->limit(10)
                ->get();

            return [
                'labels' => $rows->pluck('airport')->toArray(),
                'data' => $rows->pluck('total')->map(fn($value) => (int) $value)->toArray(),
            ];
        });
    }

    private function loadDestinationsByCountry(FiltersData $filters): array
    {
        return Cache::remember($this->cacheKey($filters, 'destinations_by_country'), now()->addMinutes(10), function () use ($filters) {
            $rows = $this->query->base($filters)
                ->leftJoin('airports', 'airports.id', '=', 'air_connectivity_routes.destination_airport_id')
                ->leftJoin('countries', 'countries.id', '=', 'airports.country_id')
                ->selectRaw('COALESCE(countries.name, "Sin país") as country, COUNT(DISTINCT air_connectivity_routes.destination_airport_id) as total')
                ->groupBy('country')
                ->orderByDesc('total')
                ->get();

            return [
                'labels' => $rows->pluck('country')->toArray(),
                'data' => $rows->pluck('total')->map(fn($value) => (int) $value)->toArray(),
            ];
        });
    }

    private function loadDestinationsByCity(FiltersData $filters): array
    {
        return Cache::remember($this->cacheKey($filters, 'destinations_by_city'), now()->addMinutes(10), function () use ($filters) {
            $rows = $this->query->base($filters)
                ->leftJoin('airports', 'airports.id', '=', 'air_connectivity_routes.destination_airport_id')
                ->leftJoin('cities', 'cities.id', '=', 'airports.city_id')
                ->selectRaw('COALESCE(cities.name, "Sin ciudad") as city, COUNT(DISTINCT air_connectivity_routes.destination_airport_id) as total')
                ->groupBy('city')
                ->orderByDesc('total')
                ->limit(10)
                ->get();

            return [
                'labels' => $rows->pluck('city')->toArray(),
                'data' => $rows->pluck('total')->map(fn($value) => (int) $value)->toArray(),
            ];
        });
    }
}
