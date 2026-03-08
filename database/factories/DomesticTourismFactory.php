<?php

namespace Database\Factories;

use App\Models\DomesticTourism;
use App\Models\Month;
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
            'travel_reason_id' => TravelReason::query()->inRandomOrder()->value('id'),
            'tourist_quantity' => $this->faker->numberBetween(100, 10000),
            'total_spend' => $this->faker->randomFloat(2, 1000000, 50000000),
            'average_stay' => $this->faker->randomFloat(2, 1, 15),
        ];
    }
}
