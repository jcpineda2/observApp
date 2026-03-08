<?php

namespace Database\Factories;

use App\Enums\Gender;
use App\Models\AgeRange;
use App\Models\EmploymentDemographic;
use App\Models\TourismEmployment;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmploymentDemographicFactory extends Factory
{
    protected $model = EmploymentDemographic::class;

    public function definition(): array
    {
        return [
            'tourism_employment_id' => TourismEmployment::query()->inRandomOrder()->value('id') ?? TourismEmployment::factory(),
            'gender' => fake()->randomElement([
                Gender::MALE,
                Gender::FEMALE,
            ]),
            'age_range_id' => AgeRange::query()->inRandomOrder()->value('id') ?? AgeRange::factory(),
            'people_count' => fake()->numberBetween(0, 10000),
        ];
    }
}
