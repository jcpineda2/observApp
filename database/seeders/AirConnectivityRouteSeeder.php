<?php

namespace Database\Seeders;

use App\Models\AirConnectivityRoute;
use App\Models\AirLine;
use App\Models\Airport;
use App\Models\Month;
use App\Models\Year;
use Illuminate\Database\Seeder;

class AirConnectivityRouteSeeder extends Seeder
{
    public function run(): void
    {
        $years = Year::query()->pluck('id', 'year');
        $months = Month::query()->orderBy('month_number')->pluck('id');
        $airLineIds = AirLine::query()->pluck('id');
        $airportIds = Airport::query()->pluck('id');

        if ($years->isEmpty() || $months->isEmpty() || $airLineIds->isEmpty() || $airportIds->count() < 2) {
            return;
        }

        foreach ($years as $yearValue => $yearId) {
            foreach ($months as $monthId) {
                foreach ($airLineIds as $airLineId) {
                    $origins = $airportIds->shuffle()->take(2);

                    foreach ($origins as $originAirportId) {
                        $destinationAirportId = $airportIds
                            ->filter(fn ($id) => $id !== $originAirportId)
                            ->shuffle()
                            ->first();

                        if (! $destinationAirportId) {
                            continue;
                        }

                        AirConnectivityRoute::updateOrCreate(
                            [
                                'year_id' => $yearId,
                                'month_id' => $monthId,
                                'air_line_id' => $airLineId,
                                'origin_airport_id' => $originAirportId,
                                'destination_airport_id' => $destinationAirportId,
                            ],
                            [
                                'is_active' => true,
                                'flights_count' => fake()->numberBetween(1, 200),
                                'seats_count' => fake()->numberBetween(100, 30000),
                            ]
                        );
                    }
                }
            }
        }
    }
}
