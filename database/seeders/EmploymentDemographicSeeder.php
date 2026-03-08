<?php

namespace Database\Seeders;

use App\Enums\Gender;
use App\Models\AgeRange;
use App\Models\EmploymentDemographic;
use App\Models\TourismEmployment;
use Illuminate\Database\Seeder;

class EmploymentDemographicSeeder extends Seeder
{
    public function run(): void
    {
        $employments = TourismEmployment::query()->pluck('id');
        $ageRanges = AgeRange::query()->pluck('id');

        if ($employments->isEmpty() || $ageRanges->isEmpty()) {
            return;
        }

        foreach ($employments as $employmentId) {
            foreach (Gender::cases() as $gender) {
                foreach ($ageRanges as $ageRangeId) {
                    EmploymentDemographic::updateOrCreate(
                        [
                            'tourism_employment_id' => $employmentId,
                            'gender' => $gender->value,
                            'age_range_id' => $ageRangeId,
                        ],
                        [
                            'people_count' => fake()->numberBetween(0, 5000),
                        ]
                    );
                }
            }
        }
    }
}
