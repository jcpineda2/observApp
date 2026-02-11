<?php

namespace Database\Factories;

use App\Models\AirLine;
use App\Models\Airport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FlightRoute>
 */
class FlightRouteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'airline_id' => AirLine::query()->inRandomOrder()->first()->id,
            'origin_airport_id' => Airport::query()->inRandomOrder()->first()->id,
            'destination_airport_id' => Airport::query()->inRandomOrder()->first()->id,
            'is_active' => $this->faker->boolean(80), // 80% chance of being active
        ];
    }
}
