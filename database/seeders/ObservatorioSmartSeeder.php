<?php

namespace Database\Seeders;

use App\Enums\Gender;
use App\Enums\IndicatorDomain;
use App\Enums\IndicatorKey;
use App\Enums\Season;
use App\Models\AccommodationCapacity;
use App\Models\AccommodationCategory;
use App\Models\AccommodationPerformance;
use App\Models\AgeRange;
use App\Models\AirConnectivityRoute;
use App\Models\AirLine;
use App\Models\Airport;
use App\Models\Country;
use App\Models\DomesticTourism;
use App\Models\EmploymentDemographic;
use App\Models\EntryMode;
use App\Models\IndicatorConstant;
use App\Models\InboundTourism;
use App\Models\Month;
use App\Models\OriginRegion;
use App\Models\ServiceSector;
use App\Models\State;
use App\Models\TourismEmployment;
use App\Models\TourismProviderStat;
use App\Models\TravelReason;
use App\Models\Year;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class ObservatorioSmartSeeder extends Seeder
{
    public function run(): void
    {
        $years = Year::query()->orderBy('year')->get(['id', 'year']);
        $months = Month::query()->orderBy('month_number')->get(['id', 'month_number']);

        $states = State::query()->limit(8)->get(['id', 'name']);
        $countries = Country::query()->limit(10)->get(['id', 'name']);
        $travelReasons = TravelReason::query()->limit(4)->get(['id', 'description']);
        $entryModes = EntryMode::query()->limit(3)->get(['id', 'description']);
        $serviceSectors = ServiceSector::query()->limit(6)->get(['id', 'description']);
        $originRegions = OriginRegion::query()->orderBy('sort_order')->get(['id', 'name']);
        $ageRanges = AgeRange::query()->orderBy('sort_order')->get(['id', 'name']);
        $accommodationCategories = AccommodationCategory::query()->limit(6)->get(['id', 'category']);
        $airLines = AirLine::query()->where('is_active', true)->get(['id', 'name']);
        $airports = Airport::query()->where('is_operational', true)->get(['id', 'name', 'country_id', 'city_id']);

        if (
            $years->isEmpty() ||
            $months->isEmpty() ||
            $states->isEmpty() ||
            $countries->isEmpty() ||
            $travelReasons->isEmpty() ||
            $entryModes->isEmpty() ||
            $serviceSectors->isEmpty() ||
            $originRegions->isEmpty() ||
            $ageRanges->isEmpty() ||
            $accommodationCategories->isEmpty() ||
            $airLines->count() < 2 ||
            $airports->count() < 2
        ) {
            return;
        }

        $this->seedDomesticIndicatorConstants($years);
        $this->seedInboundIndicatorConstants($years);

        $this->seedDomesticTourism($years, $months, $states, $originRegions, $travelReasons);
        $this->seedInboundTourism($years, $months, $countries, $states, $entryModes, $travelReasons);
        $this->seedTourismProviderStats($years, $months, $serviceSectors, $states);
        $this->seedAccommodationCapacities($accommodationCategories, $states);
        $this->seedAccommodationPerformances($years, $months, $states);
        $this->seedTourismEmployment($years, $serviceSectors, $ageRanges);
        $this->seedAirConnectivityRoutes($years, $months, $airLines, $airports);
    }

    private function seedDomesticIndicatorConstants(Collection $years): void
    {
        foreach ($years as $year) {
            $rows = [
                [
                    'key' => IndicatorKey::AvgSpendFixed->value,
                    'value' => fake()->randomFloat(2, 150000, 800000),
                    'label' => IndicatorKey::AvgSpendFixed->getLabel(),
                    'unit' => 'Gs.',
                    'source' => 'Valor fijo de referencia',
                ],
                [
                    'key' => IndicatorKey::AvgStayFixed->value,
                    'value' => fake()->randomFloat(2, 1, 7),
                    'label' => IndicatorKey::AvgStayFixed->getLabel(),
                    'unit' => 'noches',
                    'source' => 'Valor fijo de referencia',
                ],
                [
                    'key' => IndicatorKey::ExpenseCompositionFood->value,
                    'value' => 25.00,
                    'label' => IndicatorKey::ExpenseCompositionFood->getLabel(),
                    'unit' => '%',
                    'source' => 'Composición fija del gasto',
                ],
                [
                    'key' => IndicatorKey::ExpenseCompositionLodging->value,
                    'value' => 30.00,
                    'label' => IndicatorKey::ExpenseCompositionLodging->getLabel(),
                    'unit' => '%',
                    'source' => 'Composición fija del gasto',
                ],
                [
                    'key' => IndicatorKey::ExpenseCompositionTransport->value,
                    'value' => 20.00,
                    'label' => IndicatorKey::ExpenseCompositionTransport->getLabel(),
                    'unit' => '%',
                    'source' => 'Composición fija del gasto',
                ],
                [
                    'key' => IndicatorKey::ExpenseCompositionShopping->value,
                    'value' => 15.00,
                    'label' => IndicatorKey::ExpenseCompositionShopping->getLabel(),
                    'unit' => '%',
                    'source' => 'Composición fija del gasto',
                ],
                [
                    'key' => IndicatorKey::ExpenseCompositionOther->value,
                    'value' => 10.00,
                    'label' => IndicatorKey::ExpenseCompositionOther->getLabel(),
                    'unit' => '%',
                    'source' => 'Composición fija del gasto',
                ],
            ];

            foreach ($rows as $row) {
                IndicatorConstant::updateOrCreate(
                    [
                        'domain' => IndicatorDomain::Domestic->value,
                        'key' => $row['key'],
                        'year_id' => $year->id,
                    ],
                    [
                        'value' => $row['value'],
                        'label' => $row['label'],
                        'unit' => $row['unit'],
                        'source' => $row['source'],
                        'notes' => null,
                    ]
                );
            }
        }
    }

    private function seedInboundIndicatorConstants(Collection $years): void
    {
        foreach ($years as $year) {
            $rows = [
                [
                    'key' => IndicatorKey::AvgSpendFixed->value,
                    'value' => fake()->randomFloat(2, 80, 1000),
                    'label' => IndicatorKey::AvgSpendFixed->getLabel(),
                    'unit' => 'USD',
                    'source' => 'Valor fijo de referencia',
                ],
                [
                    'key' => IndicatorKey::AvgStayFixed->value,
                    'value' => fake()->randomFloat(2, 1, 12),
                    'label' => IndicatorKey::AvgStayFixed->getLabel(),
                    'unit' => 'noches',
                    'source' => 'Valor fijo de referencia',
                ],
            ];

            foreach ($rows as $row) {
                IndicatorConstant::updateOrCreate(
                    [
                        'domain' => IndicatorDomain::Inbound->value,
                        'key' => $row['key'],
                        'year_id' => $year->id,
                    ],
                    [
                        'value' => $row['value'],
                        'label' => $row['label'],
                        'unit' => $row['unit'],
                        'source' => $row['source'],
                        'notes' => null,
                    ]
                );
            }
        }
    }

    private function seedDomesticTourism(
        Collection $years,
        Collection $months,
        Collection $states,
        Collection $originRegions,
        Collection $travelReasons
    ): void {
        foreach ($years as $year) {
            foreach ($months as $month) {
                foreach ($states as $state) {
                    foreach ($originRegions as $region) {
                        foreach ($travelReasons as $reason) {
                            $payload = DomesticTourism::factory()->make([
                                'year_id' => $year->id,
                                'month_id' => $month->id,
                                'destination_department_id' => $state->id,
                                'origin_region_id' => $region->id,
                                'travel_reason_id' => $reason->id,
                            ])->toArray();

                            unset($payload['year_id'], $payload['month_id'], $payload['destination_department_id'], $payload['origin_region_id'], $payload['travel_reason_id']);

                            DomesticTourism::updateOrCreate(
                                [
                                    'year_id' => $year->id,
                                    'month_id' => $month->id,
                                    'destination_department_id' => $state->id,
                                    'origin_region_id' => $region->id,
                                    'travel_reason_id' => $reason->id,
                                ],
                                $payload
                            );
                        }
                    }
                }
            }
        }
    }

    private function seedInboundTourism(

        Collection $years,
        Collection $months,
        Collection $countries,
        Collection $states,
        Collection $entryModes,
        Collection $travelReasons
    ): void {
        foreach ($years as $year) {
            foreach ($months as $month) {
                foreach ($countries as $country) {
                    foreach ($states as $state) {
                        foreach ($entryModes as $entryMode) {
                            foreach ($travelReasons as $reason) {
                                $payload = InboundTourism::factory()->make([
                                    'year_id' => $year->id,
                                    'month_id' => $month->id,
                                    'residence_country_id' => $country->id,
                                    'destination_department_id' => $state->id,
                                    'entry_mode_id' => $entryMode->id,
                                    'travel_reason_id' => $reason->id,
                                ])->toArray();

                                unset(
                                    $payload['year_id'],
                                    $payload['month_id'],
                                    $payload['residence_country_id'],
                                    $payload['destination_department_id'],
                                    $payload['entry_mode_id'],
                                    $payload['travel_reason_id']
                                );

                                InboundTourism::updateOrCreate(
                                    [
                                        'year_id' => $year->id,
                                        'month_id' => $month->id,
                                        'residence_country_id' => $country->id,
                                        'destination_department_id' => $state->id,
                                        'entry_mode_id' => $entryMode->id,
                                        'travel_reason_id' => $reason->id,
                                    ],
                                    $payload
                                );
                            }
                        }
                    }
                }
            }
        }
    }

    private function seedTourismProviderStats(
        Collection $years,
        Collection $months,
        Collection $serviceSectors,
        Collection $states
    ): void {
        foreach ($years as $year) {
            foreach ($months as $month) {
                foreach ($serviceSectors as $sector) {
                    foreach ($states as $state) {
                        $payload = TourismProviderStat::factory()->make([
                            'year_id' => $year->id,
                            'month_id' => $month->id,
                            'service_sector_id' => $sector->id,
                            'state_id' => $state->id,
                        ])->toArray();

                        unset($payload['year_id'], $payload['month_id'], $payload['service_sector_id'], $payload['state_id']);

                        TourismProviderStat::updateOrCreate(
                            [
                                'year_id' => $year->id,
                                'month_id' => $month->id,
                                'service_sector_id' => $sector->id,
                                'state_id' => $state->id,
                            ],
                            $payload
                        );
                    }
                }
            }
        }
    }

    private function seedAccommodationCapacities(Collection $categories, Collection $states): void
    {
        foreach ($categories as $category) {
            foreach ($states as $state) {
                $payload = AccommodationCapacity::factory()->make([
                    'accommodation_category_id' => $category->id,
                    'state_id' => $state->id,
                ])->toArray();

                unset($payload['accommodation_category_id'], $payload['state_id']);

                AccommodationCapacity::updateOrCreate(
                    [
                        'accommodation_category_id' => $category->id,
                        'state_id' => $state->id,
                    ],
                    $payload
                );
            }
        }
    }

    private function seedAccommodationPerformances(
        Collection $years,
        Collection $months,
        Collection $states
    ): void {
        foreach ($years as $year) {
            foreach ($months as $month) {
                foreach ($states as $state) {
                    $payload = AccommodationPerformance::factory()->make([
                        'year_id' => $year->id,
                        'month_id' => $month->id,
                        'state_id' => $state->id,
                        'season' => $this->resolveSeason((int) $month->month_number)->value,
                    ])->toArray();

                    unset($payload['year_id'], $payload['month_id'], $payload['state_id']);

                    AccommodationPerformance::updateOrCreate(
                        [
                            'year_id' => $year->id,
                            'month_id' => $month->id,
                            'state_id' => $state->id,
                        ],
                        $payload
                    );
                }
            }
        }
    }

    private function seedTourismEmployment(
        Collection $years,
        Collection $serviceSectors,
        Collection $ageRanges
    ): void {
        foreach ($years as $year) {
            foreach ($serviceSectors as $sector) {
                $employmentPayload = TourismEmployment::factory()->make([
                    'year_id' => $year->id,
                    'service_sector_id' => $sector->id,
                ])->toArray();

                unset($employmentPayload['year_id'], $employmentPayload['service_sector_id']);

                $employment = TourismEmployment::updateOrCreate(
                    [
                        'year_id' => $year->id,
                        'service_sector_id' => $sector->id,
                    ],
                    $employmentPayload
                );

                foreach (Gender::cases() as $gender) {
                    foreach ($ageRanges as $ageRange) {
                        $demoPayload = EmploymentDemographic::factory()->make([
                            'tourism_employment_id' => $employment->id,
                            'gender' => $gender->value,
                            'age_range_id' => $ageRange->id,
                        ])->toArray();

                        unset($demoPayload['tourism_employment_id'], $demoPayload['gender'], $demoPayload['age_range_id']);

                        EmploymentDemographic::updateOrCreate(
                            [
                                'tourism_employment_id' => $employment->id,
                                'gender' => $gender->value,
                                'age_range_id' => $ageRange->id,
                            ],
                            $demoPayload
                        );
                    }
                }
            }
        }
    }

    private function seedAirConnectivityRoutes(
        Collection $years,
        Collection $months,
        Collection $airLines,
        Collection $airports
    ): void {
        $airportPairs = $this->buildAirportPairs($airports);

        foreach ($years as $year) {
            foreach ($months as $month) {
                foreach ($airLines as $airLine) {
                    foreach ($airportPairs as $pair) {
                        $payload = AirConnectivityRoute::factory()->make([
                            'year_id' => $year->id,
                            'month_id' => $month->id,
                            'air_line_id' => $airLine->id,
                            'origin_airport_id' => $pair['origin_id'],
                            'destination_airport_id' => $pair['destination_id'],
                        ])->toArray();

                        unset(
                            $payload['year_id'],
                            $payload['month_id'],
                            $payload['air_line_id'],
                            $payload['origin_airport_id'],
                            $payload['destination_airport_id']
                        );

                        AirConnectivityRoute::updateOrCreate(
                            [
                                'year_id' => $year->id,
                                'month_id' => $month->id,
                                'air_line_id' => $airLine->id,
                                'origin_airport_id' => $pair['origin_id'],
                                'destination_airport_id' => $pair['destination_id'],
                            ],
                            $payload
                        );
                    }
                }
            }
        }
    }

    private function buildAirportPairs(Collection $airports): array
    {
        $pairs = [];
        $sample = $airports->take(min(6, $airports->count()))->values();

        foreach ($sample as $origin) {
            foreach ($sample as $destination) {
                if ($origin->id === $destination->id) {
                    continue;
                }

                $pairs[] = [
                    'origin_id' => $origin->id,
                    'destination_id' => $destination->id,
                ];
            }
        }

        return array_slice($pairs, 0, 12);
    }

    private function resolveSeason(int $monthNumber): Season
    {
        return match (true) {
            in_array($monthNumber, [12, 1, 2], true) => Season::High,
            in_array($monthNumber, [6, 7], true) => Season::Low,
            default => Season::Low,
        };
    }
}
