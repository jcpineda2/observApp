<?php

namespace Database\Factories;

use App\Models\DataSource;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DataSourceFactory extends Factory
{
    protected $model = DataSource::class;

    public function definition(): array
    {
        $types = ['system', 'survey', 'spreadsheet', 'manual', 'api', 'external_official'];
        $name = fake()->unique()->company();

        return [
            'name' => $name,
            'code' => Str::upper(Str::slug($name, '_')),
            'type' => fake()->randomElement($types),
            'description' => fake()->sentence(),
            'owner' => fake()->company(),
            'is_active' => true,
        ];
    }
}
