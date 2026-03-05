<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Year;
use App\Models\Month;
use App\Models\Country;
use App\Models\State;

use App\Models\EntryMode;
use App\Models\TravelReason;
use App\Models\ServiceSector;
use App\Models\AccommodationCategory;
use App\Models\Accommodation;
use App\Models\AirLine;
use App\Models\Airport;

use App\Models\InboundTourism;
use App\Models\DomesticTourism;
use App\Models\TourismProviderStat;
use App\Models\AccommodationPerformance;
use App\Models\TourismEmployment;
use App\Models\EmploymentDemographic;
use App\Models\AirConnectivityRoute;

class ObservatorioDemoSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Catálogos base (si ya tenés seeders oficiales, llamalos desde DatabaseSeeder)
        Year::query()->count() ?: Year::factory()->count(7)->create(); // 2018..2026 por ejemplo

        // Months: ideal semillado fijo por MonthSeeder (1..12). Si no existe, lo creamos mínimo.
        if (Month::query()->count() === 0) {
            $months = [
                ['month' => 'Enero', 'month_number' => 1],
                ['month' => 'Febrero', 'month_number' => 2],
                ['month' => 'Marzo', 'month_number' => 3],
                ['month' => 'Abril', 'month_number' => 4],
                ['month' => 'Mayo', 'month_number' => 5],
                ['month' => 'Junio', 'month_number' => 6],
                ['month' => 'Julio', 'month_number' => 7],
                ['month' => 'Agosto', 'month_number' => 8],
                ['month' => 'Septiembre', 'month_number' => 9],
                ['month' => 'Octubre', 'month_number' => 10],
                ['month' => 'Noviembre', 'month_number' => 11],
                ['month' => 'Diciembre', 'month_number' => 12],
            ];
            foreach ($months as $m) {
                Month::updateOrCreate(['month_number' => $m['month_number']], ['month' => $m['month']]);
            }
        }

        EntryMode::query()->count();
        TravelReason::query()->count();
        ServiceSector::query()->count();
        AccommodationCategory::query()->count();
        AirLine::query()->count() ?: AirLine::factory()->count(6)->create();

        $countries = Country::query()->inRandomOrder()->limit(15)->get();
        $states = State::query()->with(['country' => function ($query) {
             $query->where('name', 'like', '%paraguay%');}])->get();

        // 3) Airports (necesita countries + cities)
        if (Airport::query()->count() < 8) {
            Airport::factory()->count(10)->create();
        }

        // 4) Accommodations (UNIQUE category+state)
        $categories = AccommodationCategory::all();
        foreach ($states as $state) {
            foreach ($categories->random(min(3, $categories->count())) as $cat) {
                Accommodation::updateOrCreate(
                    ['state_id' => $state->id, 'accommodation_category_id' => $cat->id],
                    Accommodation::factory()->make()->toArray()
                );
            }
        }

        // 5) Hechos por período (usar subset para no explotar)
        $years = Year::all();
        $months = Month::all();

        $entryModes = EntryMode::all();
        $reasons = TravelReason::all();
        $sectors = ServiceSector::all();

        // 5.1 Inbound: year+month+country+entry+reason (subset controlado)
        foreach ($years as $y) {
            foreach ($months as $m) {
                foreach ($countries->random(min(5, $countries->count())) as $country) {
                    $entry = $entryModes->random();
                    $reason = $reasons->random();

                    InboundTourism::updateOrCreate(
                        [
                            'year_id' => $y->id,
                            'month_id' => $m->id,
                            'residence_country_id' => $country->id,
                            'entry_mode_id' => $entry->id,
                            'travel_reason_id' => $reason->id,
                        ],
                        InboundTourism::factory()->make()->toArray()
                    );
                }
            }
        }

        // 5.2 Domestic: year+month+state(destino)+reason+origin_region (origin_region puede ser null)
        foreach ($years as $y) {
            foreach ($months as $m) {
                foreach ($states->random(min(6, $states->count())) as $dest) {
                    $reason = $reasons->random();

                    $payload = DomesticTourism::factory()->make()->toArray();

                    DomesticTourism::updateOrCreate(
                        [
                            'year_id' => $y->id,
                            'month_id' => $m->id,
                            'destination_department_id' => $dest->id,
                            'travel_reason_id' => $reason->id,
                            'origin_region' => $payload['origin_region'], // parte del unique
                        ],
                        $payload
                    );
                }
            }
        }

        // 5.3 Prestadores: year+month+sector+state
        foreach ($years as $y) {
            foreach ($months as $m) {
                foreach ($states->random(min(6, $states->count())) as $st) {
                    foreach ($sectors->random(min(4, $sectors->count())) as $sec) {
                        TourismProviderStat::updateOrCreate(
                            [
                                'year_id' => $y->id,
                                'month_id' => $m->id,
                                'service_sector_id' => $sec->id,
                                'state_id' => $st->id,
                            ],
                            TourismProviderStat::factory()->make()->toArray()
                        );
                    }
                }
            }
        }

        // 5.4 Accommodation performances: accommodation+year+month
        $accommodations = Accommodation::all();
        foreach ($accommodations as $acc) {
            foreach ($years as $y) {
                foreach ($months->random(min(6, $months->count())) as $m) { // subset
                    AccommodationPerformance::updateOrCreate(
                        [
                            'accommodation_id' => $acc->id,
                            'year_id' => $y->id,
                            'month_id' => $m->id,
                        ],
                        AccommodationPerformance::factory()->make()->toArray()
                    );
                }
            }
        }

        // 5.5 Employment: year+sector + demographics (gender+age_range unique)
        foreach ($years as $y) {
            foreach ($sectors->random(min(6, $sectors->count())) as $sec) {
                $employment = TourismEmployment::updateOrCreate(
                    [
                        'year_id' => $y->id,
                        'service_sector_id' => $sec->id,
                    ],
                    TourismEmployment::factory()->make()->toArray()
                );

                // Demográficos: combos controlados
                $genders = ['male', 'female'];
                $ranges = ['15-24', '25-34', '35-44', '45-54', '55+'];

                foreach ($genders as $g) {
                    foreach ($ranges as $r) {
                        EmploymentDemographic::updateOrCreate(
                            [
                                'tourism_employment_id' => $employment->id,
                                'gender' => $g,
                                'age_range' => $r,
                            ],
                            ['people_count' => rand(0, 200000)]
                        );
                    }
                }
            }
        }

        // 5.6 Air connectivity: year+month+airline+origin+dest (evitar origin=dest)
        $airlines = AirLine::all();
        $airports = Airport::all();

        foreach ($years as $y) {
            foreach ($months as $m) {
                foreach ($airlines->random(min(4, $airlines->count())) as $al) {
                    for ($i = 0; $i < 6; $i++) {
                        $origin = $airports->random();
                        $dest = $airports->where('id', '!=', $origin->id)->random();

                        AirConnectivityRoute::updateOrCreate(
                            [
                                'year_id' => $y->id,
                                'month_id' => $m->id,
                                'air_line_id' => $al->id,
                                'origin_airport_id' => $origin->id,
                                'destination_airport_id' => $dest->id,
                            ],
                            AirConnectivityRoute::factory()->make()->toArray()
                        );
                    }
                }
            }
        }
    }
}
