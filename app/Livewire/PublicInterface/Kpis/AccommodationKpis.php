<?php

namespace App\Livewire\PublicInterface\Kpis;

use App\Models\Accommodation;
use App\Models\AccommodationCategory;
use App\Models\AccommodationPerformance;
use App\Models\Year;
use Livewire\Component;

class AccommodationKpis extends Component
{
    public ?int $year = null;
    public ?int $month = null;

    public int $accommodationsCount = 0;
    public int $categoriesCount = 0;
    public float $avgOccupancyRate = 0.0;
    public ?string $dominantSeason = null;

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

    private function perfQuery()
    {
        return AccommodationPerformance::query()
            ->when($this->year, fn ($q) => $q->where('year_id', $this->year))
            ->when($this->month, fn ($q) => $q->where('month_id', $this->month));
    }

    private function recalculate(): void
    {
        // KPI 1: stock establecimientos
        $this->accommodationsCount = (int) Accommodation::query()->count();

        // KPI 3: categorías
        $this->categoriesCount = (int) AccommodationCategory::query()->count();

        // KPIs dependientes de performances
        if (! $this->year) {
            $this->avgOccupancyRate = 0;
            $this->dominantSeason = null;
            return;
        }

        // KPI 2: ocupación promedio del período (AVG)
        $this->avgOccupancyRate = round((float) $this->perfQuery()->avg('occupancy_rate'), 2);

        // KPI 4: temporada dominante del período (más frecuente)
        $this->dominantSeason = $this->perfQuery()
            ->selectRaw('season, COUNT(*) as c')
            ->groupBy('season')
            ->orderByDesc('c')
            ->value('season');
    }

    public function render()
    {
        return view('livewire.public-interface.kpis.accommodation-kpis');
    }
}
