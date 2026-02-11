<?php

namespace Database\Factories;

use App\Enums\Gender;
use App\Models\EmploymentDemographic;
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
            'tourism_employment_id' => TourismEmployment::query()->inRandomOrder()->first()->id,
            'gender' => $this->faker->randomElement(Gender::cases()),
            'age_range' => $this->faker->randomElement(['18-24', '25-34', '35-44', '45-54', '55-64', '65+']),
            'people_count' => $this->faker->numberBetween(1, 100),
        ];
    }
}
