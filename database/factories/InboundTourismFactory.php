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
            'tourist_arrivals' => $this->faker->numberBetween(0, 200000),
            'excursionist_arrivals' => $this->faker->numberBetween(0, 80000),
            'foreign_exchange_revenue' => $this->faker->randomFloat(2, 0, 50000000),
            'average_spend' => $this->faker->randomFloat(2, 0, 800),
            'average_stay' => $this->faker->randomFloat(2, 0, 20),
        ];
    }
}
