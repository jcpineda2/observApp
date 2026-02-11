<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProviderIndicator>
 */
class ProviderIndicatorFactory extends Factory
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
            'total_providers' => $this->faker->numberBetween(100, 1000),
            'new_registrations' => $this->faker->numberBetween(10, 100),
            'cancellations' => $this->faker->numberBetween(5, 50),
            'formalization_rate' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
