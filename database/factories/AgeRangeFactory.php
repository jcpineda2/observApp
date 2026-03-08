<?php

namespace Database\Factories;

use App\Models\AgeRange;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgeRangeFactory extends Factory
{
    protected $model = AgeRange::class;

    public function definition(): array
    {
        static $ranges = [
            ['name' => '15-24 años', 'sort_order' => 1],
            ['name' => '25-34 años', 'sort_order' => 2],
            ['name' => '35-44 años', 'sort_order' => 3],
            ['name' => '45-54 años', 'sort_order' => 4],
            ['name' => '55-64 años', 'sort_order' => 5],
            ['name' => '65 y más', 'sort_order' => 6],
        ];

        $item = fake()->randomElement($ranges);

        return [
            'name' => $item['name'],
            'sort_order' => $item['sort_order'],
        ];
    }
}
