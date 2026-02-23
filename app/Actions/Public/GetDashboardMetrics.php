<?php

namespace App\Actions\Public;

use App\Models\AccommodationPerformance;
use App\Models\ConnectivityIndicator;
use App\Models\DomesticTourism;
use App\Models\InboundTourism;
use App\Models\Year;
use Illuminate\Support\Facades\Cache;

class GetDashboardMetrics
{
    public function handle(?int $yearId = null, ?int $monthId = null): array
    {
        $yearId = $yearId ?: Year::query()->max('id'); // “último año cargado” por id
        $cacheKey = "public_dashboard_metrics:year={$yearId}:month={$monthId}";

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($yearId, $monthId) {
            // Turismo receptivo (inbound)
            $inbound = InboundTourism::query()
                ->where('year_id', $yearId)
                ->when($monthId, fn ($q) => $q->where('month_id', $monthId))
                ->selectRaw('
                    COALESCE(SUM(tourist_arrivals), 0) as tourists,
                    COALESCE(SUM(excursionist_arrivals), 0) as excursionists,
                    COALESCE(SUM(foreign_exchange_revenue), 0) as revenue
                ')
                ->first();

            // Turismo interno (domestic)
            $domestic = DomesticTourism::query()
                ->where('year_id', $yearId)
                ->when($monthId, fn ($q) => $q->where('month_id', $monthId))
                ->selectRaw('
                    COALESCE(SUM(tourist_quantity), 0) as tourists,
                    COALESCE(SUM(total_spend), 0) as spend
                ')
                ->first();

            // Alojamiento (promedio ocupación)
            $accommodation = AccommodationPerformance::query()
                ->where('year_id', $yearId)
                ->when($monthId, fn ($q) => $q->where('month_id', $monthId))
                ->selectRaw('COALESCE(AVG(occupancy_rate), 0) as avg_occupancy')
                ->first();

            // Conectividad (por año)
            $connectivity = ConnectivityIndicator::query()
                ->where('year_id', $yearId)
                ->first();

            return [
                'year_id' => $yearId,
                'month_id' => $monthId,

                'inbound' => [
                    'tourists' => (int) ($inbound->tourists ?? 0),
                    'excursionists' => (int) ($inbound->excursionists ?? 0),
                    'revenue' => (float) ($inbound->revenue ?? 0),
                ],

                'domestic' => [
                    'tourists' => (int) ($domestic->tourists ?? 0),
                    'spend' => (float) ($domestic->spend ?? 0),
                ],

                'accommodation' => [
                    'avg_occupancy' => (float) ($accommodation->avg_occupancy ?? 0),
                ],

                'connectivity' => [
                    'operating_airports' => (int) ($connectivity->operating_airports ?? 0),
                    'connected_destinations' => (int) ($connectivity->connected_destinations ?? 0),
                    'active_routes' => (int) ($connectivity->active_routes ?? 0),
                ],
            ];
        });
    }
}
