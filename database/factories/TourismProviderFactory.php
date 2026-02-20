<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Models\ServiceSector;
use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TourismProvider>
 */
class TourismProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'service_sector_id' => ServiceSector::query()->inRandomOrder()->first()->id,
            'state_id' => State::query()->inRandomOrder()->first()->id ,
            'registration_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(Status::cases()),
        ];
    }
}
