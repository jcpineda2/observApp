<?php

namespace Database\Factories;

use App\Models\Month;
use App\Models\State;
use App\Models\Year;
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
            'origin_region' => $this->faker->boolean(70)
                ? $this->faker->randomElement(['Central', 'Norte', 'Sur', 'Este', 'Oeste'])
                : null,
            'tourist_quantity' => $this->faker->numberBetween(0, 300000),
            'total_spend' => $this->faker->randomFloat(2, 0, 80000000),
            'average_stay' => $this->faker->randomFloat(2, 0, 20),
            'spend_composition' => $this->faker->boolean(30) ? $this->faker->sentence(8) : null,
        ];
    }
}
