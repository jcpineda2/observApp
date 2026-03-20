<?php

namespace Database\Factories;

use App\Models\DataSourceRun;
use App\Models\InboundArrivalByMonth;
use App\Models\Month;
use App\Models\Year;
use Illuminate\Database\Eloquent\Factories\Factory;

class InboundArrivalByMonthFactory extends Factory
{
    protected $model = InboundArrivalByMonth::class;

    public function definition(): array
    {
        return [
            'year_id' => Year::query()->inRandomOrder()->value('id') ?? Year::factory(),
            'month_id' => Month::query()->inRandomOrder()->value('id') ?? Month::factory(),
            'tourist_arrivals' => fake()->numberBetween(1000, 500000),
            'data_source_run_id' => DataSourceRun::query()->inRandomOrder()->value('id'),
            'source_note' => fake()->boolean(25) ? fake()->sentence() : null,
        ];
    }
}
