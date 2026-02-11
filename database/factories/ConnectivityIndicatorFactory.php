<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ConnectivityIndicator>
 */
class ConnectivityIndicatorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'year_id' => \App\Models\Year::factory(),
            'operating_airports' => $this->faker->numberBetween(1, 100),
            'connected_destinations' => $this->faker->numberBetween(1, 100),
            'active_routes' => $this->faker->numberBetween(1, 100),
        ];
    }
}
