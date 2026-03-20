<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\DataSourceRun;
use App\Models\InboundArrivalByCountry;
use App\Models\ReportPeriod;
use Illuminate\Database\Eloquent\Factories\Factory;

class InboundArrivalByCountryFactory extends Factory
{
    protected $model = InboundArrivalByCountry::class;

    public function definition(): array
    {
        return [
            'report_period_id' => ReportPeriod::query()->inRandomOrder()->value('id') ?? ReportPeriod::factory(),
            'country_id' => Country::query()->inRandomOrder()->value('id') ?? Country::factory(),
            'tourist_arrivals' => fake()->numberBetween(100, 500000),
            'data_source_run_id' => DataSourceRun::query()->inRandomOrder()->value('id'),
            'source_note' => fake()->boolean(25) ? fake()->sentence() : null,
        ];
    }
}
