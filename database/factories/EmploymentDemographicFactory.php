<?php

namespace Database\Factories;

use App\Enums\Gender;
use App\Models\TourismEmployment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmploymentDemographic>
 */
class EmploymentDemographicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'gender' => $this->faker->randomElement(['male', 'female']),
            'age_range' => $this->faker->randomElement(['15-24', '25-34', '35-44', '45-54', '55+']),
            'people_count' => $this->faker->numberBetween(0, 300000),
        ];
    }
}
