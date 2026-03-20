<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\EntryMode;
use App\Models\EntryPoint;
use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntryPointFactory extends Factory
{
    protected $model = EntryPoint::class;

    public function definition(): array
    {
        return [
            'entry_mode_id' => EntryMode::query()->inRandomOrder()->value('id') ?? EntryMode::factory(),
            'name' => fake()->unique()->company() . ' - Punto de Entrada',
            'state_id' => State::query()->inRandomOrder()->value('id'),
            'country_id' => Country::query()->inRandomOrder()->value('id'),
            'is_active' => true,
            'sort_order' => fake()->numberBetween(1, 100),
        ];
    }
}
