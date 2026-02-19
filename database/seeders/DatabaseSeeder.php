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

        $years = range(2018, 2026);

        foreach ($years as $year) {
            Year::firstOrCreate(['year' => $year]);
        }
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

        $yearIds  = Year::query()->pluck('id')->all();
        $monthIds = Month::query()->pluck('id')->all();

        $accommodations = Accommodation::query()->pluck('id')->all();

        // Ejemplo: genera 1 año por alojamiento, 12 meses (o lo que quieras)
        foreach ($accommodations as $accId) {
            $yearId = fake()->randomElement($yearIds);

            foreach ($monthIds as $monthId) {
                AccommodationPerformance::updateOrCreate(
                    [
                        'accommodation_id' => $accId,
                        'year_id' => $yearId,
                        'month_id' => $monthId,
                    ],
                    [
                        'occupancy_rate' => fake()->randomFloat(2, 0, 100),
                        'season' => fake()->randomElement(['High', 'Low', 'Shoulder']),
                    ]
                );
            }
        }
        foreach (Year::query()->pluck('id') as $yearId) {
            ConnectivityIndicator::updateOrCreate(
                ['year_id' => $yearId],
                [
                    'operating_airports' => fake()->numberBetween(1, 100),
                    'connected_destinations' => fake()->numberBetween(1, 100),
                    'active_routes' => fake()->numberBetween(1, 100),
                ]
            );
        }
        foreach (Year::query()->pluck('id') as $yearId) {
            ProviderIndicator::updateOrCreate(
                ['year_id' => $yearId],
                [
                    'total_providers' => fake()->numberBetween(100, 2000),
                    'new_registrations' => fake()->numberBetween(10, 200),
                    'cancellations' => fake()->numberBetween(1, 100),
                    'formalization_rate' => fake()->randomFloat(2, 0, 100),
                ]
            );
        }

        $yearIds = Year::query()->pluck('id')->all();
        $sectorIds = ServiceSector::query()->pluck('id')->all();

        foreach ($yearIds as $yearId) {
            foreach ($sectorIds as $sectorId) {
                TourismEmployment::updateOrCreate(
                    [
                        'year_id' => $yearId,
                        'service_sector_id' => $sectorId,
                    ],
                    [
                        'direct_employment' => fake()->numberBetween(100, 10000),
                        'national_participation' => fake()->randomFloat(2, 0, 100),
                        'interannual_variation' => fake()->randomFloat(2, -10, 10),
                    ]
                );
            }
        }
        $genders = ['male', 'female'];
        $ageRanges = ['18-24', '25-34', '35-44', '45-54', '55-64', '65+'];

        $tourismEmployments = TourismEmployment::query()->pluck('id')->all();

        foreach ($tourismEmployments as $employmentId) {
            foreach ($genders as $gender) {
                foreach ($ageRanges as $ageRange) {
                    EmploymentDemographic::updateOrCreate(
                        [
                            'tourism_employment_id' => $employmentId,
                            'gender' => $gender,
                            'age_range' => $ageRange,
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
