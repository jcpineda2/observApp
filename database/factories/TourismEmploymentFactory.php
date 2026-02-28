<?php

namespace Database\Factories;

use App\Models\ServiceSector;
use App\Models\Year;
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
            'direct_employment' => $this->faker->numberBetween(0, 500000),
            'national_participation' => $this->faker->randomFloat(2, 0, 100),
            'interannual_variation' => $this->faker->randomFloat(2, -50, 50),
        ];
    }
}
