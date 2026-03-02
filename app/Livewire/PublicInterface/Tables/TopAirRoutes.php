<?php

namespace App\Livewire\PublicInterface\Tables;

use App\Models\AirConnectivityRoute;
use App\Models\Year;
use Livewire\Component;

class TopAirRoutes extends Component
{
    public ?int $year = null;
    public ?int $month = null;

    public int $limit = 15;

    /** @var array<int, array<string, mixed>> */
    public array $rows = [];

    protected $listeners = [
        'public-filters-updated' => 'onFiltersUpdated',
    ];

    public function mount(): void
    {
        if (! $this->year) {
            $this->year = Year::query()->orderByDesc('year')->value('id');
        }

        $this->loadRows();
    }

    public function onFiltersUpdated($year, $month): void
    {
        $this->year  = $year ?: null;
        $this->month = $month ?: null;

        $this->loadRows();
    }

    private function loadRows(): void
    {
        if (! $this->year) {
            $this->rows = [];
            return;
        }

        // ⚠️ Ajustes posibles:
        // - airports.name vs airports.description
        // - air_lines.name vs air_lines.description
        // Si tu esquema usa description, cambiá COALESCE(...) abajo.

        $items = AirConnectivityRoute::query()
            ->leftJoin('air_lines', 'air_lines.id', '=', 'air_connectivity_routes.air_line_id')
            ->leftJoin('airports as o', 'o.id', '=', 'air_connectivity_routes.origin_airport_id')
            ->leftJoin('airports as d', 'd.id', '=', 'air_connectivity_routes.destination_airport_id')
            ->where('air_connectivity_routes.year_id', $this->year)
            ->when($this->month, fn ($q) => $q->where('air_connectivity_routes.month_id', $this->month))
            ->selectRaw('
                COALESCE(air_lines.name, air_lines.name, "Sin aerolínea") as airline,
                COALESCE(o.name, o.name, "Origen") as origin,
                COALESCE(d.name, d.name, "Destino") as destination,
                SUM(air_connectivity_routes.flights_count) as flights,
                SUM(air_connectivity_routes.seats_count) as seats,
                MAX(air_connectivity_routes.is_active) as is_active
            ')
            ->groupBy('airline', 'origin', 'destination')
            ->orderByDesc('seats')
            ->limit($this->limit)
            ->get();

        $rank = 1;

        $this->rows = $items->map(function ($r) use (&$rank) {
            return [
                'rank' => $rank++,
                'route' => "{$r->origin} → {$r->destination}",
                'airline' => (string) $r->airline,
                'flights' => (int) $r->flights,
                'seats' => (int) $r->seats,
                'is_active' => (bool) $r->is_active,
            ];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.public-interface.tables.top-air-routes');
    }
}
