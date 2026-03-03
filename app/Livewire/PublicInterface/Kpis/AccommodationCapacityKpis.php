<?php

namespace App\Livewire\PublicInterface\Kpis;

use App\Models\Accommodation;
use App\Models\AccommodationPerformance;
use App\Models\Year;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class AccommodationCapacityKpis extends Component
{
    public ?int $year = null;
    public ?int $month = null;

    public ?int $installedRooms = null;
    public ?int $installedBeds = null;
    public ?int $installedSeats = null;

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
        $this->year  = $year ?: null;
        $this->month = $month ?: null;

        $this->recalculate();
    }

    private function firstExistingColumn(string $table, array $candidates): ?string
    {
        foreach ($candidates as $col) {
            if (Schema::hasColumn($table, $col)) {
                return $col;
            }
        }
        return null;
    }

    private function sumForActiveAccommodations(?string $column): ?int
    {
        if (! $column) return null;
        if (! $this->year) return null;

        // IDs de alojamientos que tienen performance en el período seleccionado
        $activeIds = AccommodationPerformance::query()
            ->where('year_id', $this->year)
            ->when($this->month, fn ($q) => $q->where('month_id', $this->month))
            ->distinct()
            ->pluck('accommodation_id');

        if ($activeIds->isEmpty()) return 0;

        // Sumamos capacidad instalada SOLO de esos alojamientos
        return (int) Accommodation::query()
            ->whereIn('id', $activeIds)
            ->sum($column);
    }

    private function recalculate(): void
    {
        // Detectamos nombres reales de columnas en accommodations
        $roomsCol = $this->firstExistingColumn('accommodations', [
            'rooms', 'room_count', 'rooms_count', 'total_rooms', 'rooms_total', 'cantidad_habitaciones',
        ]);

        $bedsCol = $this->firstExistingColumn('accommodations', [
            'beds', 'bed_count', 'beds_count', 'total_beds', 'beds_total', 'cantidad_camas',
        ]);

        $seatsCol = $this->firstExistingColumn('accommodations', [
            'seats', 'capacity', 'installed_capacity', 'total_capacity', 'plazas', 'plazas_total',
        ]);

        // ✅ Capacidad instalada "aplicando filtros": solo alojamientos con performance en el período
        $this->installedRooms = $this->sumForActiveAccommodations($roomsCol);
        $this->installedBeds  = $this->sumForActiveAccommodations($bedsCol);
        $this->installedSeats = $this->sumForActiveAccommodations($seatsCol);
    }

    public function render()
    {
        return view('livewire.public-interface.kpis.accommodation-capacity-kpis');
    }
}
