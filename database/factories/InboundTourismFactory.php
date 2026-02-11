<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\EntryMode;
use App\Models\Month;
use App\Models\TravelReason;
use App\Models\Year;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InboundTourism>
 */
class InboundTourismFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'year_id' => Year::query()->inRandomOrder()->first()->id,
            'month_id' => Month::query()->inRandomOrder()->first()->id,
            'residence_country_id' => Country::query()->inRandomOrder()->first()->id,
            'entry_mode_id' => EntryMode::inRandomOrder()->first()?->id,
            'travel_reason_id' => TravelReason::query()->inRandomOrder()->first()->id,
            'tourist_arrivals' => $this->faker->numberBetween(1000, 100000),
            'excursionist_arrivals' => $this->faker->numberBetween(500, 50000),
            'foreign_exchange_revenue' => $this->faker->randomFloat(2, 10000, 1000000),
            'average_spend' => $this->faker->randomFloat(2, 50, 500),
            'average_stay' => $this->faker->randomFloat(2, 1, 14),
        ];
    }
}
