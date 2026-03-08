<?php

namespace Database\Factories;

use App\Models\DomesticTourism;
use App\Models\Month;
use App\Models\OriginRegion;
use App\Models\State;
use App\Models\TravelReason;
use App\Models\Year;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DomesticTourism>
 */
class DomesticTourismFactory extends Factory
{
    protected $model = DomesticTourism::class;

    public function definition(): array
    {
        return [
            'year_id' => Year::query()->inRandomOrder()->value('id') ?? Year::factory(),
            'month_id' => Month::query()->inRandomOrder()->value('id') ?? Month::factory(),
            'destination_department_id' => State::query()->inRandomOrder()->value('id'),
            'origin_region_id' => OriginRegion::query()->inRandomOrder()->value('id') ?? OriginRegion::factory(),
            'travel_reason_id' => TravelReason::query()->inRandomOrder()->value('id') ?? TravelReason::factory(),
            'tourist_quantity' => fake()->numberBetween(100, 10000),
            'total_spend' => fake()->randomFloat(2, 1000000, 50000000),
            'average_stay' => fake()->randomFloat(2, 1, 15),
        ];
    }
}
