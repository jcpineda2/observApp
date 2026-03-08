<?php

namespace Database\Seeders;

use App\Models\AgeRange;
use Illuminate\Database\Seeder;

class AgeRangeSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['name' => '15-24 años', 'sort_order' => 1],
            ['name' => '25-34 años', 'sort_order' => 2],
            ['name' => '35-44 años', 'sort_order' => 3],
            ['name' => '45-54 años', 'sort_order' => 4],
            ['name' => '55-64 años', 'sort_order' => 5],
            ['name' => '65 y más', 'sort_order' => 6],
        ];

        foreach ($rows as $row) {
            AgeRange::updateOrCreate(
                ['name' => $row['name']],
                ['sort_order' => $row['sort_order']]
            );
        }
    }
}
