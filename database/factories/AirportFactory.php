<?php

namespace Database\Factories;

use App\Enums\Scope;
use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Airport>
 */
class AirportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'name' => fake()->unique()->company() . ' Airport',
            'country_id' => Country::query()->inRandomOrder()->value('id') ?? Country::factory(),
            'city_id' => City::query()->inRandomOrder()->value('id'),
            'scope' => fake()->randomElement([
                Scope::NATIONAL,
                Scope::INTERNATIONAL,
            ]),
            'is_operational' => true,
        ];
    }
}
