<?php

namespace Database\Factories;

use App\Models\AccommodationCapacity;
use App\Models\AccommodationCategory;
use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccommodationCapacityFactory extends Factory
{
    protected $model = AccommodationCapacity::class;

    public function definition(): array
    {
        return [
            'accommodation_category_id' => AccommodationCategory::query()->inRandomOrder()->value('id')
                ?? AccommodationCategory::factory(),
            'state_id' => State::query()->inRandomOrder()->value('id')
                ?? State::factory(),
            'establishments_count' => $this->faker->numberBetween(1, 200),
            'rooms_count' => $this->faker->numberBetween(10, 5000),
            'beds_count' => $this->faker->numberBetween(20, 10000),
        ];
    }
}
