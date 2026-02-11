<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DomesticTourism>
 */
class DomesticTourismFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'year_id' => $this->faker->numberBetween(1, 5),
            'month_id' => $this->faker->numberBetween(1, 12),
            'destination_department_id' => $this->faker->numberBetween(1, 10),
            'travel_reason_id' => $this->faker->numberBetween(1, 5),
            'origin_region' => $this->faker->state(),
            'tourist_quantity' => $this->faker->numberBetween(1, 1000),
            'total_spend' => $this->faker->randomFloat(2, 1000, 100000),
            'average_stay' => $this->faker->randomFloat(2, 1, 30),
            'spend_composition' => $this->faker->sentence(),
        ];
    }
}
