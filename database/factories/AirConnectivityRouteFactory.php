<?php

namespace Database\Factories;

use App\Models\AirLine;
use App\Models\Airport;
use App\Models\Month;
use App\Models\Year;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AirConnectivityRoute>
 */
class AirConnectivityRouteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $originAirportId = Airport::query()->inRandomOrder()->value('id') ?? Airport::factory();
        $destinationAirportId = Airport::query()
            ->where('id', '!=', $originAirportId)
            ->inRandomOrder()
            ->value('id') ?? Airport::factory();

        return [
            'year_id' => Year::query()->inRandomOrder()->value('id') ?? Year::factory(),
            'month_id' => Month::query()->inRandomOrder()->value('id') ?? Month::factory(),
            'air_line_id' => AirLine::query()->inRandomOrder()->value('id') ?? AirLine::factory(),
            'origin_airport_id' => $originAirportId,
            'destination_airport_id' => $destinationAirportId,
            'is_active' => true,
            'flights_count' => fake()->numberBetween(0, 500),
            'seats_count' => fake()->numberBetween(0, 100000),
        ];
    }
}
