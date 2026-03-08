<?php

namespace Database\Seeders;

use App\Models\IndicatorConstant;
use App\Models\Year;
use Illuminate\Database\Seeder;

class IndicatorConstantSeeder extends Seeder
{
    public function run(): void
    {
        $year2024 = Year::query()->where('year', 2024)->value('id');
        $year2025 = Year::query()->where('year', 2025)->value('id');

        $rows = [
            [
                'domain' => 'domestic',
                'key' => 'avg_spend_fixed',
                'year_id' => $year2024,
                'value' => 185000.0000,
                'meta' => ['label' => 'Gasto promedio fijo'],
            ],
            [
                'domain' => 'domestic',
                'key' => 'avg_stay_fixed',
                'year_id' => $year2024,
                'value' => 3.2000,
                'meta' => ['label' => 'Estadía promedio fija'],
            ],
            [
                'domain' => 'domestic',
                'key' => 'avg_spend_fixed',
                'year_id' => $year2025,
                'value' => 215000.0000,
                'meta' => ['label' => 'Gasto promedio fijo'],
            ],
            [
                'domain' => 'domestic',
                'key' => 'avg_stay_fixed',
                'year_id' => $year2025,
                'value' => 3.4000,
                'meta' => ['label' => 'Estadía promedio fija'],
            ],
            [
                'domain' => 'inbound',
                'key' => 'avg_spend_fixed',
                'year_id' => $year2024,
                'value' => 390.5000,
                'meta' => ['label' => 'Gasto promedio fijo'],
            ],
            [
                'domain' => 'inbound',
                'key' => 'avg_stay_fixed',
                'year_id' => $year2024,
                'value' => 4.9000,
                'meta' => ['label' => 'Estadía promedio fija'],
            ],
            [
                'domain' => 'inbound',
                'key' => 'avg_spend_fixed',
                'year_id' => $year2025,
                'value' => 412.5000,
                'meta' => ['label' => 'Gasto promedio fijo'],
            ],
            [
                'domain' => 'inbound',
                'key' => 'avg_stay_fixed',
                'year_id' => $year2025,
                'value' => 5.1000,
                'meta' => ['label' => 'Estadía promedio fija'],
            ],
        ];

        foreach ($rows as $row) {
            IndicatorConstant::updateOrCreate(
                [
                    'domain' => $row['domain'],
                    'key' => $row['key'],
                    'year_id' => $row['year_id'],
                ],
                [
                    'value' => $row['value'],
                    'meta' => $row['meta'],
                ]
            );
        }
    }
}
