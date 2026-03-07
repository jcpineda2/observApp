<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Month;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            RolesAndPermissionsSeeder::class,
            CountrySeeder::class,
            UserSeeder::class,
            YearSeeder::class,
            MonthSeeder::class,
            EntryModeSeeder::class,
            AirLineSeeder::class,
            AirportSeeder::class,
            TravelReasonSeeder::class,
            ServiceSectorSeeder::class,
            AccommodationCategorySeeder::class,
            ObservatorioDemoSeeder::class
        ]);


     }
}
