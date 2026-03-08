<?php

namespace Database\Factories;

use App\Enums\Season;
use App\Models\Accommodation;
use App\Models\Month;
use App\Models\State;
use App\Models\Year;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AccommodationPerformance>
 */
class AccommodationPerformanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'year_id' => Year::query()->inRandomOrder()->value('id') ?? Year::factory(),
            'month_id' => Month::query()->inRandomOrder()->value('id') ?? Month::factory(),
            'state_id' => State::query()->inRandomOrder()->value('id') ?? State::factory(),
            'occupancy_rate' => $this->faker->randomFloat(2, 5, 100),
            'season' => $this->faker->randomElement([
                Season::High->value,
                Season::Low->value,
            ]),
        ];
    }
}
