<?php

namespace Database\Seeders;

use App\Models\ServiceSector;
use App\Models\TourismEmployment;
use App\Models\Year;
use Illuminate\Database\Seeder;

class TourismEmploymentSeeder extends Seeder
{
    public function run(): void
    {
        $years = Year::query()->pluck('id', 'year');
        $sectors = ServiceSector::query()->pluck('id');

        if ($years->isEmpty() || $sectors->isEmpty()) {
            return;
        }

        foreach ($years as $yearValue => $yearId) {
            foreach ($sectors as $sectorId) {
                TourismEmployment::updateOrCreate(
                    [
                        'year_id' => $yearId,
                        'service_sector_id' => $sectorId,
                    ],
                    [
                        'direct_employment' => fake()->numberBetween(100, 15000),
                        'national_participation' => fake()->randomFloat(2, 0.10, 20.00),
                        'interannual_variation' => fake()->randomFloat(2, -15.00, 15.00),
                    ]
                );
            }
        }
    }
}
