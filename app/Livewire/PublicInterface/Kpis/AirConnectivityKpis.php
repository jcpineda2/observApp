<?php

namespace App\Livewire\PublicInterface\Kpis;

use App\Models\AirConnectivityRoute;
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
    public int $airports = 0;

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
        if (! $this->year) {
            $this->activeRoutes = 0;
            $this->totalFlights = 0;
            $this->totalSeats = 0;
            $this->airlines = 0;
            $this->airports = 0;
            return;
        }

        $q = AirConnectivityRoute::query()
            ->where('year_id', $this->year)
            ->when($this->month, fn ($qq) => $qq->where('month_id', $this->month));

        $this->activeRoutes = (int) (clone $q)->where('is_active', true)->count();

        $this->totalFlights = (int) (clone $q)->sum('flights_count');
        $this->totalSeats = (int) (clone $q)->sum('seats_count');

        $this->airlines = (int) (clone $q)->distinct('air_line_id')->count('air_line_id');

        // aeropuertos únicos (origen + destino)
        $originIds = (clone $q)->distinct()->pluck('origin_airport_id')->filter()->unique();
        $destIds   = (clone $q)->distinct()->pluck('destination_airport_id')->filter()->unique();

        $this->airports = $originIds->merge($destIds)->unique()->count();
    }

    public function render()
    {
        return view('livewire.public-interface.kpis.air-connectivity-kpis');
    }
}
