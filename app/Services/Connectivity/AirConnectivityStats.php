<?php

namespace App\Services\Connectivity;

use App\Models\AirConnectivityRoute;
use Illuminate\Support\Collection;

class AirConnectivityStats
{
    public function latestPeriod(): ?array
    {
        $latest = AirConnectivityRoute::query()
            ->select('year_id', 'month_id')
            ->orderByDesc('year_id')
            ->orderByDesc('month_id')
            ->first();

        return $latest ? ['year_id' => $latest->year_id, 'month_id' => $latest->month_id] : null;
    }

    public function kpis(int $yearId, int $monthId, ?int $airLineId = null, ?int $destCountryId = null, ?int $destCityId = null): array
    {
        $q = AirConnectivityRoute::query()
            ->where('year_id', $yearId)
            ->where('month_id', $monthId)
            ->where('is_active', true);

        if ($airLineId) {
            $q->where('air_line_id', $airLineId);
        }

        if ($destCountryId) {
            $q->whereHas('destinationAirport.country', fn ($qq) => $qq->where('id', $destCountryId));
        }

        if ($destCityId) {
            $q->whereHas('destinationAirport.city', fn ($qq) => $qq->where('id', $destCityId));
        }

        $routesActive = (int) $q->count();

        $originIds = (clone $q)->pluck('origin_airport_id')->unique();
        $destIds   = (clone $q)->pluck('destination_airport_id')->unique();

        $airportsOperational = $originIds->merge($destIds)->unique()->count();
        $destinationsConnected = $destIds->count();

        return [
            'airports_operational' => (int) $airportsOperational,
            'destinations_connected' => (int) $destinationsConnected,
            'routes_active' => (int) $routesActive,
        ];
    }

    public function monthlySeries(int $yearId, ?int $airLineId = null, ?int $destCountryId = null, ?int $destCityId = null): Collection
    {
        $q = AirConnectivityRoute::query()
            ->selectRaw('month_id, SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as routes_active')
            ->where('year_id', $yearId);

        if ($airLineId) {
            $q->where('air_line_id', $airLineId);
        }

        if ($destCountryId) {
            $q->whereHas('destinationAirport.country', fn ($qq) => $qq->where('id', $destCountryId));
        }

        if ($destCityId) {
            $q->whereHas('destinationAirport.city', fn ($qq) => $qq->where('id', $destCityId));
        }

        return $q->groupBy('month_id')
            ->orderBy('month_id')
            ->get();
    }
}
