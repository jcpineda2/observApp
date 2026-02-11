<?php

namespace Database\Factories;

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
            'airline_id' => \App\Models\AirlLine::factory(),
            'origin_airport_id' => \App\Models\Airport::factory(),
            'destination_airport_id' => \App\Models\Airport::factory(),
            'is_active' => $this->faker->boolean(80), // 80% chance of being active
        ];
    }
}
