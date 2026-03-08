<?php

namespace Database\Seeders;

use App\Models\AccommodationCapacity;
use App\Models\AccommodationCategory;
use App\Models\State;
use Illuminate\Database\Seeder;

class AccommodationCapacitySeeder extends Seeder
{
    public function run(): void
    {
        $categories = AccommodationCategory::query()->pluck('id');
        $states = State::query()->pluck('id');

        if ($categories->isEmpty() || $states->isEmpty()) {
            return;
        }

        foreach ($states as $stateId) {
            foreach ($categories as $categoryId) {
                AccommodationCapacity::updateOrCreate(
                    [
                        'accommodation_category_id' => $categoryId,
                        'state_id' => $stateId,
                    ],
                    [
                        'establishments_count' => fake()->numberBetween(1, 150),
                        'rooms_count' => fake()->numberBetween(20, 4000),
                        'beds_count' => fake()->numberBetween(40, 8000),
                    ]
                );
            }
        }
    }
}
