<?php

namespace Database\Factories;

use App\Models\AccommodationCategory;
use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Accommodation>
 */
class AccommodationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'accommodation_category_id' => AccommodationCategory::query()->inRandomOrder()->first()->id,
            'state_id' => State::Query()->inRandomOrder()->first()->id,
            'establishments_count' => $this->faker->numberBetween(1, 10),
            'rooms_count' => $this->faker->numberBetween(1, 100),
            'beds_count' => $this->faker->numberBetween(1, 200),
        ];
    }
}
