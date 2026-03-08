<?php

namespace Database\Factories;

use App\Models\ServiceSector;
use App\Models\TourismEmployment;
use App\Models\Year;
use Illuminate\Database\Eloquent\Factories\Factory;

class TourismEmploymentFactory extends Factory
{
    protected $model = TourismEmployment::class;

    public function definition(): array
    {
        return [
            'year_id' => Year::query()->inRandomOrder()->value('id') ?? Year::factory(),
            'service_sector_id' => ServiceSector::query()->inRandomOrder()->value('id') ?? ServiceSector::factory(),
            'direct_employment' => fake()->numberBetween(50, 20000),
            'national_participation' => fake()->randomFloat(2, 0.10, 25.00),
            'interannual_variation' => fake()->randomFloat(2, -20.00, 20.00),
        ];
    }
}
