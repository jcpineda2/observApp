<?php

namespace App\Livewire\PublicInterface\Sections;

use App\Models\Accommodation;
use App\Models\AccommodationCategory;
use App\Models\AccommodationPerformance;
use App\Models\AirConnectivityRoute;
use App\Models\AirLine;
use App\Models\Airport;
use App\Models\Country;
use App\Models\DomesticTourism;
use App\Models\EmploymentDemographic;
use App\Models\EntryMode;
use App\Models\InboundTourism;
use App\Models\ServiceSector;
use App\Models\State;
use App\Models\TourismEmployment;
use App\Models\TourismProviderStat;
use App\Models\TravelReason;
use App\Models\Year;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class PrincipalAllKpis extends Component
{
    public ?int $year = null;
    public ?int $month = null;

    /** @var array<string, array<int, array{title:string,value:string,subtitle?:string}>> */
    public array $groups = [];

    protected $listeners = [
        'public-filters-updated' => 'onFiltersUpdated',
    ];

    public function mount(): void
    {
        if (! $this->year) {
            $this->year = Year::query()->orderByDesc('year')->value('id');
        }

        $this->recalculate();
    }

    public function onFiltersUpdated($year, $month): void
    {
        $this->year = $year ?: null;
        $this->month = $month ?: null;

        $this->recalculate();
    }

    private function nf($n, int $decimals = 0): string
    {
        return number_format((float) $n, $decimals, ',', '.');
    }

    private function filterYearMonth(Builder $q, string $yearCol = 'year_id', string $monthCol = 'month_id'): Builder
    {
        if ($this->year) {
            $q->where($yearCol, $this->year);
        }
        if ($this->month) {
            $q->where($monthCol, $this->month);
        }
        return $q;
    }

    private function recalculate(): void
    {
        $y = $this->year;
        $m = $this->month;

        $groups = [];

        // =========================
        // PRINCIPALES (tipo Registur)
        // =========================
        $establishments = (int) Accommodation::query()->sum('establishments_count');

        $groups['Principales'][] = [
            'title' => 'Establecimientos (Alojamientos)',
            'value' => $this->nf($establishments),
            'subtitle' => 'Suma de accommodations.establishments_count',
        ];

        // =========================
        // TURISMO RECEPTIVO
        // =========================
        $inboundTourists = (int) $this->filterYearMonth(InboundTourism::query())->sum('tourist_arrivals');
        $inboundExc = (int) $this->filterYearMonth(InboundTourism::query())->sum('excursionist_arrivals');
        $inboundFX = (float) $this->filterYearMonth(InboundTourism::query())->sum('foreign_exchange_revenue');

        $groups['Turismo receptivo'][] = ['title' => 'Llegadas (Turistas)', 'value' => $this->nf($inboundTourists)];
        $groups['Turismo receptivo'][] = ['title' => 'Llegadas (Excursionistas)', 'value' => $this->nf($inboundExc)];
        $groups['Turismo receptivo'][] = ['title' => 'Divisas (ingresos)', 'value' => $this->nf($inboundFX), 'subtitle' => 'Suma de foreign_exchange_revenue'];

        // =========================
        // TURISMO INTERNO
        // =========================
        $domTrips = (int) $this->filterYearMonth(DomesticTourism::query())->sum('tourist_quantity');
        $domSpend = (float) $this->filterYearMonth(DomesticTourism::query())->sum('total_spend');

        $groups['Turismo interno'][] = ['title' => 'Viajes (cantidad)', 'value' => $this->nf($domTrips)];
        $groups['Turismo interno'][] = ['title' => 'Gasto total', 'value' => $this->nf($domSpend)];

        // =========================
        // CONECTIVIDAD AÉREA
        // =========================
        $airFlights = (int) $this->filterYearMonth(AirConnectivityRoute::query())->sum('flights_count');
        $airSeats = (int) $this->filterYearMonth(AirConnectivityRoute::query())->sum('seats_count');

        // “Rutas activas” como conteo de registros marcados activos (según filtros)
        $airActive = (int) $this->filterYearMonth(AirConnectivityRoute::query())->where('is_active', true)->count();

        $airAirlines = (int) $this->filterYearMonth(AirConnectivityRoute::query())->distinct('air_line_id')->count('air_line_id');
        $airOrigins = (int) $this->filterYearMonth(AirConnectivityRoute::query())->distinct('origin_airport_id')->count('origin_airport_id');
        $airDest = (int) $this->filterYearMonth(AirConnectivityRoute::query())->distinct('destination_airport_id')->count('destination_airport_id');

        $groups['Conectividad aérea'][] = ['title' => 'Vuelos', 'value' => $this->nf($airFlights)];
        $groups['Conectividad aérea'][] = ['title' => 'Asientos', 'value' => $this->nf($airSeats)];
        $groups['Conectividad aérea'][] = ['title' => 'Rutas activas', 'value' => $this->nf($airActive)];
        $groups['Conectividad aérea'][] = ['title' => 'Aerolíneas (únicas)', 'value' => $this->nf($airAirlines)];
        $groups['Conectividad aérea'][] = ['title' => 'Aeropuertos origen (únicos)', 'value' => $this->nf($airOrigins)];
        $groups['Conectividad aérea'][] = ['title' => 'Aeropuertos destino (únicos)', 'value' => $this->nf($airDest)];

        // =========================
        // ALOJAMIENTOS (instalados + ocupación)
        // =========================
        $rooms = (int) Accommodation::query()->sum('rooms_count');
        $beds  = (int) Accommodation::query()->sum('beds_count');

        $occAvg = (float) $this->filterYearMonth(AccommodationPerformance::query())->avg('occupancy_rate'); // porcentaje real (ej 75.32)

        $groups['Alojamientos'][] = ['title' => 'Habitaciones instaladas', 'value' => $this->nf($rooms)];
        $groups['Alojamientos'][] = ['title' => 'Camas instaladas', 'value' => $this->nf($beds)];
        $groups['Alojamientos'][] = [
            'title' => 'Ocupación promedio',
            'value' => $occAvg ? $this->nf($occAvg, 2) . '%' : '—',
            'subtitle' => 'Promedio de occupancy_rate',
        ];

        // =========================
        // EMPLEO
        // =========================
        $directEmployment = $y ? (int) TourismEmployment::query()->where('year_id', $y)->sum('direct_employment') : 0;
        $avgNatPart = $y ? (float) TourismEmployment::query()->where('year_id', $y)->avg('national_participation') : 0.0;
        $avgInterVar = $y ? (float) TourismEmployment::query()->where('year_id', $y)->avg('interannual_variation') : 0.0;

        // total de personas en demographics (por año)
        $demoPeople = 0;
        if ($y) {
            $demoPeople = (int) EmploymentDemographic::query()
                ->leftJoin('tourism_employments', 'tourism_employments.id', '=', 'employment_demographics.tourism_employment_id')
                ->where('tourism_employments.year_id', $y)
                ->sum('employment_demographics.people_count');
        }

        $groups['Empleo'][] = ['title' => 'Empleo directo (total)', 'value' => $this->nf($directEmployment)];
        $groups['Empleo'][] = [
            'title' => 'Participación nacional (prom.)',
            'value' => $avgNatPart ? $this->nf($avgNatPart, 2) . '%' : '—',
        ];
        $groups['Empleo'][] = [
            'title' => 'Variación interanual (prom.)',
            'value' => $avgInterVar ? $this->nf($avgInterVar, 2) . '%' : '—',
        ];
        $groups['Empleo'][] = ['title' => 'Demografía (personas)', 'value' => $this->nf($demoPeople)];

        // =========================
        // PRESTADORES (TourismProviderStat)
        // =========================
        $providersTotalRegistered = (int) $this->filterYearMonth(TourismProviderStat::query())->sum('total_registered');
        $providersRegistrations = (int) $this->filterYearMonth(TourismProviderStat::query())->sum('registrations');
        $providersCancellations = (int) $this->filterYearMonth(TourismProviderStat::query())->sum('cancellations');
        $providersFormalized = (int) $this->filterYearMonth(TourismProviderStat::query())->sum('formalized_total');

        $formalPct = 0.0;
        if ($providersTotalRegistered > 0) {
            $formalPct = round(($providersFormalized / $providersTotalRegistered) * 100, 2);
        }

        $groups['Prestadores'][] = ['title' => 'Total registrados', 'value' => $this->nf($providersTotalRegistered)];
        $groups['Prestadores'][] = ['title' => 'Altas (registrations)', 'value' => $this->nf($providersRegistrations)];
        $groups['Prestadores'][] = ['title' => 'Bajas (cancellations)', 'value' => $this->nf($providersCancellations)];
        $groups['Prestadores'][] = ['title' => 'Formalizados (total)', 'value' => $this->nf($providersFormalized)];
        $groups['Prestadores'][] = ['title' => '% formalización', 'value' => $providersTotalRegistered ? $this->nf($formalPct, 2) . '%' : '—'];

        // =========================
        // CATÁLOGOS (tablas maestras)
        // =========================
        $groups['Catálogos'][] = ['title' => 'Años', 'value' => $this->nf(Year::query()->count())];
        $groups['Catálogos'][] = ['title' => 'Meses', 'value' => $this->nf(\App\Models\Month::query()->count())];
        $groups['Catálogos'][] = ['title' => 'Países', 'value' => $this->nf(Country::query()->count())];
        $groups['Catálogos'][] = ['title' => 'Departamentos', 'value' => $this->nf(State::query()->count())];
        $groups['Catálogos'][] = ['title' => 'Motivos de viaje', 'value' => $this->nf(TravelReason::query()->count())];
        $groups['Catálogos'][] = ['title' => 'Vías de ingreso', 'value' => $this->nf(EntryMode::query()->count())];
        $groups['Catálogos'][] = ['title' => 'Rubros (Service Sectors)', 'value' => $this->nf(ServiceSector::query()->count())];
        $groups['Catálogos'][] = ['title' => 'Categorías de alojamiento', 'value' => $this->nf(AccommodationCategory::query()->count())];
        $groups['Catálogos'][] = ['title' => 'Aerolíneas', 'value' => $this->nf(AirLine::query()->count())];
        $groups['Catálogos'][] = ['title' => 'Aeropuertos', 'value' => $this->nf(Airport::query()->count())];

        $this->groups = $groups;
    }

    public function render()
    {
        return view('livewire.public-interface.sections.principal-all-kpis');
    }
}
