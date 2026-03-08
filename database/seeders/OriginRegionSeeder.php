<?php

namespace Database\Seeders;

use App\Models\OriginRegion;
use Illuminate\Database\Seeder;

class OriginRegionSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['name' => 'Asunción', 'sort_order' => 1],
            ['name' => 'Central', 'sort_order' => 2],
            ['name' => 'Norte', 'sort_order' => 3],
            ['name' => 'Sur', 'sort_order' => 4],
            ['name' => 'Este', 'sort_order' => 5],
            ['name' => 'Oeste', 'sort_order' => 6],
        ];

        foreach ($rows as $row) {
            OriginRegion::updateOrCreate(
                ['name' => $row['name']],
                ['sort_order' => $row['sort_order']]
            );
        }
    }
}
