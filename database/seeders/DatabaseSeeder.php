<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Month;
use Illuminate\Database\Seeder;
use Termwind\Components\Ol;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ObservatorioSmartSeeder::class,
        ]);

        // $this->call([
        //     RolesAndPermissionsSeeder::class,
        //     CountrySeeder::class,
        //     UserSeeder::class,
        //     YearSeeder::class,
        //     MonthSeeder::class,
        //     EntryModeSeeder::class,
        //     AirLineSeeder::class,
        //     AirportSeeder::class,
        //     AirConnectivityRouteSeeder::class,
        //     TravelReasonSeeder::class,
        //     ServiceSectorSeeder::class,
        //     AgeRangeSeeder::class,
        //     AccommodationCategorySeeder::class,
        //     AccommodationCapacitySeeder::class,
        //     TourismEmploymentSeeder::class,
        //     EmploymentDemographicSeeder::class,
        //     AccommodationPerformanceSeeder::class,
        //     TourismEmploymentSeeder::class,
        //     EmploymentDemographicSeeder::class,
        // ]);
    }
}
