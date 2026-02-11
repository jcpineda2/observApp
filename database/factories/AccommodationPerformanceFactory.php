<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AccommodationPerformance>
 */
class AccommodationPerformanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'accommodation_id' => \App\Models\Accommodation::factory(),
            'year_id' => \App\Models\Year::factory(),
            'month_id' => \App\Models\Month::factory(),
            'occupancy_rate' => $this->faker->randomFloat(2, 0, 100),
            'season' => $this->faker->randomElement(['High', 'Low', 'Shoulder']),
        ];
    }
}
