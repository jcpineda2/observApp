<?php

namespace Database\Seeders;

use App\Enums\Season;
use App\Models\AccommodationPerformance;
use App\Models\Month;
use App\Models\State;
use App\Models\Year;
use Illuminate\Database\Seeder;

class AccommodationPerformanceSeeder extends Seeder
{
    public function run(): void
    {
        $years = Year::query()->pluck('id', 'year');
        $months = Month::query()->orderBy('month_number')->get(['id', 'month_number']);
        $states = State::query()->pluck('id');

        if ($years->isEmpty() || $months->isEmpty() || $states->isEmpty()) {
            return;
        }

        foreach ($years as $yearValue => $yearId) {
            foreach ($months as $month) {
                foreach ($states as $stateId) {
                    AccommodationPerformance::updateOrCreate(
                        [
                            'year_id' => $yearId,
                            'month_id' => $month->id,
                            'state_id' => $stateId,
                        ],
                        [
                            'occupancy_rate' => fake()->randomFloat(2, 10, 95),
                            'season' => $this->resolveSeason((int) $month->month_number)->value,
                        ]
                    );
                }
            }
        }
    }

    private function resolveSeason(int $monthNumber): Season
    {
        return match (true) {
            in_array($monthNumber, [12, 1, 2], true) => Season::High,
            default => Season::Low,
        };
    }
}
