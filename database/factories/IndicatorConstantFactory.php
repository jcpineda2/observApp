<?php

namespace Database\Factories;

use App\Enums\IndicatorDomain;
use App\Enums\IndicatorKey;
use App\Models\IndicatorConstant;
use App\Models\Year;
use Illuminate\Database\Eloquent\Factories\Factory;

class IndicatorConstantFactory extends Factory
{
    protected $model = IndicatorConstant::class;

    public function definition(): array
    {

        return [
            'domain' => $this->faker->randomElement(
                IndicatorDomain::cases()
            ),
            'key' => $this->faker->randomElement(
                IndicatorKey::cases()),
            'year_id' => Year::query()->inRandomOrder()->value('id'),
            'value' => $this->faker->randomFloat(4, 1, 500000),
            'label' => $this->faker->randomElement([
                'Gasto promedio fijo',
                'Estadía promedio fija',
            ]),
            'unit' => $this->faker->randomElement(['USD', 'Gs.', 'noches']),
            'source' => 'Dato demo',
            'notes' => null,
        ];
    }
}
