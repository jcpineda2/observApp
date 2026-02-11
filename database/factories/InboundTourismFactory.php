<?php

namespace Database\Factories;

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
            'year_id' => \App\Models\Year::factory(),
            'month_id' => \App\Models\Month::factory(),
            'residence_country_id' => \App\Models\Country::factory(),
            'entry_mode_id' => \App\Models\EntryMode::factory(),
            'travel_reason_id' => \App\Models\TravelReason::factory(),

            'tourist_arrivals' => $this->faker->numberBetween(1000, 100000),
            'excursionist_arrivals' => $this->faker->numberBetween(500, 50000),
            'foreign_exchange_revenue' => $this->faker->randomFloat(2, 10000, 1000000),
            'average_spend' => $this->faker->randomFloat(2, 50, 500),
            'average_stay' => $this->faker->randomFloat(2, 1, 14),
        ];
    }
}
