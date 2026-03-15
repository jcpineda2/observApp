<?php

namespace App\Data\Public;

final class ConnectivityDashboardData
{
    public function __construct(
        public readonly array $kpis = [],
        public readonly array $flightsSeatsByMonth = [],
        public readonly array $topAirlinesBySeats = [],
        public readonly array $topRoutes = [],
        public readonly array $topOriginAirports = [],
        public readonly array $topDestinationAirports = [],
        public readonly array $destinationsByCountry = [],
        public readonly array $destinationsByCity = [],
    ) {}

    public function toArray(): array
    {
        return [
            'kpis' => $this->kpis,
            'flightsSeatsByMonth' => $this->flightsSeatsByMonth,
            'topAirlinesBySeats' => $this->topAirlinesBySeats,
            'topRoutes' => $this->topRoutes,
            'topOriginAirports' => $this->topOriginAirports,
            'topDestinationAirports' => $this->topDestinationAirports,
            'destinationsByCountry' => $this->destinationsByCountry,
            'destinationsByCity' => $this->destinationsByCity,
        ];
    }
}
