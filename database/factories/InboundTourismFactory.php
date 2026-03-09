<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\EntryMode;
use App\Models\InboundTourism;
use App\Models\Month;
use App\Models\State;
use App\Models\TravelReason;
use App\Models\Year;
use Illuminate\Database\Eloquent\Factories\Factory;

class InboundTourismFactory extends Factory
{
    protected $model = InboundTourism::class;

    public function definition(): array
    {
        return [
            'year_id' => Year::query()->inRandomOrder()->value('id') ?? Year::factory(),
            'month_id' => Month::query()->inRandomOrder()->value('id') ?? Month::factory(),
            'residence_country_id' => Country::query()->inRandomOrder()->value('id') ?? Country::factory(),
            'destination_department_id' => State::query()->inRandomOrder()->value('id'),
            'entry_mode_id' => EntryMode::query()->inRandomOrder()->value('id') ?? EntryMode::factory(),
            'travel_reason_id' => TravelReason::query()->inRandomOrder()->value('id') ?? TravelReason::factory(),
            'tourist_arrivals' => fake()->numberBetween(10, 10000),
            'excursionist_arrivals' => fake()->numberBetween(0, 5000),
            'foreign_exchange_revenue' => fake()->randomFloat(2, 1000, 5000000),
            'average_spend' => fake()->randomFloat(2, 50, 1000),
            'average_stay' => fake()->randomFloat(2, 1, 15),
        ];
    }
}
