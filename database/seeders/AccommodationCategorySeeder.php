<?php

namespace Database\Seeders;

use App\Models\AccommodationCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccommodationCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AccommodationCategory::create([
            'category' => 'Hoteles',
        ]);
        AccommodationCategory::create([
            'category' => 'Posadas',
        ]);
        AccommodationCategory::create([
            'category' => 'Apart-hoteles',
        ]);
        AccommodationCategory::create([
            'category' => 'Lodges',
        ]);
        AccommodationCategory::create([
            'category' => 'Hostales',
        ]);
    }
}
