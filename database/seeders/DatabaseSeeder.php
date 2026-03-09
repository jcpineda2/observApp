<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;


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
            UserSeeder::class,
            AgeRangeSeeder::class,
            CountrySeeder::class,
            OriginRegionSeeder::class,
            YearSeeder::class,
            MonthSeeder::class,
            EntryModeSeeder::class,
            TravelReasonSeeder::class,
            AirLineSeeder::class,
            ServiceSectorSeeder::class,
            AccommodationCategorySeeder::class,
            AirportSeeder::class,
            ObservatorioSmartSeeder::class,
        ]);

    }
}
