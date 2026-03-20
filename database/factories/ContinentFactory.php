<?php

namespace Database\Factories;

use App\Models\Continent;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContinentFactory extends Factory
{
    protected $model = Continent::class;

    public function definition(): array
    {
        static $continents = [
            ['name' => 'África', 'sort_order' => 1],
            ['name' => 'América', 'sort_order' => 2],
            ['name' => 'Asia', 'sort_order' => 3],
            ['name' => 'Europa', 'sort_order' => 4],
            ['name' => 'Oceanía', 'sort_order' => 5],
        ];

        $row = fake()->randomElement($continents);

        return [
            'name' => $row['name'],
            'sort_order' => $row['sort_order'],
            'is_active' => true,
        ];
    }
}
