<?php

namespace Database\Factories;

use App\Models\Accommodation;
use App\Models\Month;
use App\Models\Year;
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
            'occupancy_rate' => $this->faker->randomFloat(2, 0, 100),
            'season' => $this->faker->randomElement(['Alta', 'Baja', null]),
        ];
    }
}
