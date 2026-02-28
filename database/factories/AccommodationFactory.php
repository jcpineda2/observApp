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
            'establishments_count' => $this->faker->numberBetween(0, 500),
            'rooms_count' => $this->faker->numberBetween(0, 10000),
            'beds_count' => $this->faker->numberBetween(0, 20000),
        ];
    }
}
