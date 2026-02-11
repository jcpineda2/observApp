<?php

namespace Database\Factories;

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
            'accommodation_category_id' => \App\Models\AccommodationCategory::factory(),
            'state_id' => \App\Models\State::factory(),
            'establishments_count' => $this->faker->numberBetween(1, 10),
            'rooms_count' => $this->faker->numberBetween(1, 100),
            'beds_count' => $this->faker->numberBetween(1, 200),
        ];
    }
}
