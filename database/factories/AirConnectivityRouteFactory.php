<?php

namespace Database\Factories;

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
        return [
            'is_active' => $this->faker->boolean(80),
            'flights_count' => $this->faker->numberBetween(0, 400),
            'seats_count' => $this->faker->numberBetween(0, 80000),
        ];
    }
}
