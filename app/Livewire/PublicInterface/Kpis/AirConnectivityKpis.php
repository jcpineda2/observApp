<?php

namespace App\Livewire\PublicInterface\Kpis;

use App\Enums\Scope;
use App\Models\AirConnectivityRoute;
use App\Models\Airport;
use App\Models\Year;
use Livewire\Component;

class AirConnectivityKpis extends Component
{
    public ?int $year = null;
    public ?int $month = null;

    public int $activeRoutes = 0;
    public int $totalFlights = 0;
    public int $totalSeats = 0;
    public int $airlines = 0;
    public int $airportsInRoutes = 0;

    public int $operationalNationalAirports = 0;
    public int $operationalInternationalAirports = 0;
    public int $connectedDestinations = 0;

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

    private function recalculate(): void
    {

        $this->operationalNationalAirports = Airport::query()
            ->where('is_operational', true)
            ->where('scope', Scope::NATIONAL)
            ->count();

        $this->operationalInternationalAirports = Airport::query()
            ->where('is_operational', true)
            ->where('scope', Scope::INTERNATIONAL)
            ->count();

        if (! $this->year) {
            $this->activeRoutes = 0;
            $this->totalFlights = 0;
            $this->totalSeats = 0;
            $this->airlines = 0;
            $this->airportsInRoutes = 0;
            $this->connectedDestinations = 0;
            return;
        }

        $q = AirConnectivityRoute::query()
            ->where('year_id', $this->year)
            ->when($this->month, fn($qq) => $qq->where('month_id', $this->month));

        $this->activeRoutes = (int) (clone $q)->where('is_active', true)->count();

        $this->totalFlights = (int) (clone $q)->sum('flights_count');
        $this->totalSeats = (int) (clone $q)->sum('seats_count');

        $this->airlines = (int) (clone $q)->distinct('air_line_id')->count('air_line_id');

        // aeropuertos únicos (origen + destino)
        $originIds = (clone $q)->distinct()->pluck('origin_airport_id')->filter()->unique();
        $destIds   = (clone $q)->distinct()->pluck('destination_airport_id')->filter()->unique();

        $this->airportsInRoutes = $originIds->merge($destIds)->unique()->count();

        $this->connectedDestinations = (int) (clone $q)->distinct('destination_airport_id')->count('destination_airport_id');
    }

    public function render()
    {
        return view('livewire.public-interface.kpis.air-connectivity-kpis');
    }
}
