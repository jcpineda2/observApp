<?php

namespace Database\Seeders;

use App\Models\Accommodation;
use App\Models\AccommodationCategory;
use App\Models\AccommodationPerformance;
use App\Models\AirLine;
use App\Models\Airport;
use App\Models\ConnectivityIndicator;
use App\Models\DomesticTourism;
use App\Models\EmploymentDemographic;
use App\Models\EntryMode;
use App\Models\FlightRoute;
use App\Models\InboundTourism;
use App\Models\Month;
use App\Models\ProviderIndicator;
use App\Models\ServiceSector;
use App\Models\TourismEmployment;
use App\Models\TourismProvider;
use App\Models\TravelReason;
use App\Models\User;
use App\Models\Year;
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
            UserSeeder::class,
            CountrySeeder::class,
        ]);

        Year::factory()->count(10)->create();                // O: firstOrCreate por rango fijo
        Month::factory()->count(12)->create();
        EntryMode::factory()->count(6)->create();
        TravelReason::factory()->count(8)->create();
        AirLine::factory()->count(8)->create();
        ServiceSector::factory()->count(10)->create();
        AccommodationCategory::factory()->count(8)->create();

        // 4) Entidades que dependen de catálogos/ubicación
        Airport::factory()->count(20)->create();            // necesita countries y cities
        FlightRoute::factory()->count(40)->create();        // necesita airports y airlines

        Accommodation::factory()->count(20)->create();      // necesita states + accommodation_categories
        TourismProvider::factory()->count(30)->create();    // necesita states + service_sectors

        // 5) Hechos/indicadores (dependen de years/months/etc)
        InboundTourism::factory()->count(200)->create();    // necesita years, months, entry_modes, travel_reasons, countries
        DomesticTourism::factory()->count(200)->create();   // necesita years, months, states, travel_reasons

        AccommodationPerformance::factory()->count(200)->create(); // necesita accommodations, years, months
        ConnectivityIndicator::factory()->count(50)->create();     // necesita years
        ProviderIndicator::factory()->count(50)->create();         // necesita years

        TourismEmployment::factory()->count(50)->create();         // necesita years + service_sectors
        EmploymentDemographic::factory()->count(200)->create();    // necesita tourism_employments
    }
}
