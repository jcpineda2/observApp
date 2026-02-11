<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TourismEmployment>
 */
class TourismEmploymentFactory extends Factory
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
            'service_sector_id' => \App\Models\ServiceSector::factory(),
            'direct_employment' => $this->faker->numberBetween(100, 10000),
            'national_participation' => $this->faker->randomFloat(2, 0, 100),
            'interannual_variation' => $this->faker->randomFloat(2, -10, 10),
        ];
    }
}
