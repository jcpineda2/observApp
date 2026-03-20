<?php

namespace Database\Factories;

use App\Models\DataSourceRun;
use App\Models\EntryPoint;
use App\Models\InboundArrivalByEntryPoint;
use App\Models\ReportPeriod;
use Illuminate\Database\Eloquent\Factories\Factory;

class InboundArrivalByEntryPointFactory extends Factory
{
    protected $model = InboundArrivalByEntryPoint::class;

    public function definition(): array
    {
        return [
            'report_period_id' => ReportPeriod::query()->inRandomOrder()->value('id') ?? ReportPeriod::factory(),
            'entry_point_id' => EntryPoint::query()->inRandomOrder()->value('id') ?? EntryPoint::factory(),
            'tourist_arrivals' => fake()->numberBetween(100, 500000),
            'data_source_run_id' => DataSourceRun::query()->inRandomOrder()->value('id'),
            'source_note' => fake()->boolean(25) ? fake()->sentence() : null,
        ];
    }
}
