<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TourismProviderStat>
 */
class TourismProviderStatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $registrations = $this->faker->numberBetween(0, 500);
        $cancellations = $this->faker->numberBetween(0, 200);

        return [
            'total_registered' => $this->faker->numberBetween(0, 20000),
            'registrations' => $registrations,
            'cancellations' => $cancellations,
            'formalized_total' => $this->faker->numberBetween(0, 20000),
        ];
    }
}
