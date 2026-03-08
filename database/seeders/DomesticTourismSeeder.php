<?php

namespace Database\Seeders;

use App\Models\DomesticTourism;
use App\Models\Month;
use App\Models\OriginRegion;
use App\Models\State;
use App\Models\TravelReason;
use App\Models\Year;
use Illuminate\Database\Seeder;

class DomesticTourismSeeder extends Seeder
{
    public function run(): void
    {
        $years = Year::query()->pluck('id', 'year');
        $months = Month::query()->orderBy('month_number')->pluck('id');
        $regions = OriginRegion::query()->pluck('id');
        $reasons = TravelReason::query()->pluck('id');
        $states = State::query()->pluck('id');

        if (
            $years->isEmpty() ||
            $months->isEmpty() ||
            $regions->isEmpty() ||
            $reasons->isEmpty() ||
            $states->isEmpty()
        ) {
            return;
        }

        foreach ($years as $yearValue => $yearId) {
            foreach ($months as $monthId) {
                foreach ($states->take(8) as $stateId) {
                    foreach ($regions as $regionId) {
                        foreach ($reasons->take(4) as $reasonId) {
                            DomesticTourism::updateOrCreate(
                                [
                                    'year_id' => $yearId,
                                    'month_id' => $monthId,
                                    'destination_department_id' => $stateId,
                                    'origin_region_id' => $regionId,
                                    'travel_reason_id' => $reasonId,
                                ],
                                [
                                    'tourist_quantity' => fake()->numberBetween(50, 3000),
                                    'total_spend' => fake()->randomFloat(2, 500000, 20000000),
                                    'average_stay' => fake()->randomFloat(2, 1, 12),
                                ]
                            );
                        }
                    }
                }
            }
        }
    }
}
