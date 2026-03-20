<?php

namespace Database\Factories;

use App\Models\DataSource;
use App\Models\DataSourceRun;
use App\Models\ReportPeriod;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DataSourceRunFactory extends Factory
{
    protected $model = DataSourceRun::class;

    public function definition(): array
    {
        $statuses = ['draft', 'imported', 'validated', 'rejected'];

        return [
            'data_source_id' => DataSource::query()->inRandomOrder()->value('id') ?? DataSource::factory(),
            'report_period_id' => ReportPeriod::query()->inRandomOrder()->value('id'),
            'name' => 'Carga ' . fake()->date('Y-m-d H:i'),
            'source_file_name' => fake()->boolean(80) ? fake()->slug() . '.xlsx' : null,
            'source_file_path' => fake()->boolean(70) ? 'imports/' . fake()->slug() . '.xlsx' : null,
            'source_sheet_name' => fake()->boolean(60) ? 'Hoja ' . fake()->numberBetween(1, 5) : null,
            'external_reference' => fake()->boolean(50) ? 'EXT-' . fake()->numerify('#####') : null,
            'source_url' => fake()->boolean(30) ? fake()->url() : null,
            'checksum' => fake()->boolean(50) ? fake()->sha256() : null,
            'extracted_at' => fake()->boolean(70) ? fake()->dateTimeBetween('-1 year', 'now') : null,
            'imported_at' => fake()->boolean(80) ? fake()->dateTimeBetween('-1 year', 'now') : null,
            'validated_at' => fake()->boolean(40) ? fake()->dateTimeBetween('-1 year', 'now') : null,
            'imported_by' => User::query()->inRandomOrder()->value('id'),
            'validated_by' => User::query()->inRandomOrder()->value('id'),
            'status' => fake()->randomElement($statuses),
            'notes' => fake()->boolean(30) ? fake()->sentence() : null,
        ];
    }
}
