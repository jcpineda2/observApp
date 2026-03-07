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
        $country = Country::inRandomOrder()->first();
        $city = City::where('country_id', $country?->id)->inRandomOrder()->first()
            ?? City::inRandomOrder()->first();
        return [
            'name' => 'Aeropuerto ' . $this->faker->unique()->city(),
            'country_id' => $country->id,
            'city_id' => $city->id,
            'scope' => $this->faker->randomElement(Scope::cases()),
            'is_operational' => $this->faker->boolean(85),
        ];
    }
}
