<?php

namespace Database\Factories;

use App\Models\OriginRegion;
use Illuminate\Database\Eloquent\Factories\Factory;

class OriginRegionFactory extends Factory
{
    protected $model = OriginRegion::class;

    public function definition(): array
    {
        static $rows = [
            ['name' => 'Asunción', 'sort_order' => 1],
            ['name' => 'Central', 'sort_order' => 2],
            ['name' => 'Norte', 'sort_order' => 3],
            ['name' => 'Sur', 'sort_order' => 4],
            ['name' => 'Este', 'sort_order' => 5],
            ['name' => 'Oeste', 'sort_order' => 6],
        ];

        $row = fake()->randomElement($rows);

        return [
            'name' => $row['name'],
            'sort_order' => $row['sort_order'],
        ];
    }
}
