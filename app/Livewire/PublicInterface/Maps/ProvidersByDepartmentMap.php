<?php

namespace App\Livewire\PublicInterface\Maps;

use App\Models\TourismProviderStat;
use App\Models\Year;
use Livewire\Component;

class ProvidersByDepartmentMap extends Component
{
    public ?int $year = null;
    public ?int $month = null;

    // Para identificar el contenedor del mapa (si tuvieras más de uno)
    public string $mapId = 'providers_map_departments';

    protected $listeners = [
        'public-filters-updated' => 'onFiltersUpdated',
    ];

    public function mount(): void
    {
        if (! $this->year) {
            $this->year = Year::query()->orderByDesc('year')->value('id');
        }

        $this->dispatchMapUpdate();
    }

    public function onFiltersUpdated($year, $month): void
    {
        $this->year  = $year ?: null;
        $this->month = $month ?: null;

        $this->dispatchMapUpdate();
    }

    private function dispatchMapUpdate(): void
    {
        if (! $this->year) {
            $this->dispatch('observatorio:map:update', mapId: $this->mapId, data: []);
            $this->dispatch('observatorio:map:ranking', mapId: $this->mapId, ranking: []);
            return;
        }

        // ✅ stock por departamento (MAX para evitar inflar)
        $rows = TourismProviderStat::query()
            ->where('tourism_provider_stats.year_id', $this->year)
            ->when($this->month, fn($q) => $q->where('tourism_provider_stats.month_id', $this->month))
            ->leftJoin('states', 'states.id', '=', 'tourism_provider_stats.state_id')
            ->selectRaw('COALESCE(states.name, "Sin departamento") as department, MAX(tourism_provider_stats.total_registered) as stock')
            ->groupBy('department')
            ->orderByDesc('stock')
            ->get();

        $dataByDept = $rows->pluck('stock', 'department')
            ->map(fn($v) => (int) $v)
            ->toArray();

        // Ranking Top 10 + Otros
        $top = $rows->take(10)->map(fn($r) => [
            'label' => $r->department,
            'value' => (int) $r->stock,
        ])->values()->toArray();

        $sumTop = array_sum(array_column($top, 'value'));
        $totalAll = array_sum(array_map('intval', $dataByDept));
        $others = max(0, $totalAll - $sumTop);

        $ranking = $top;
        $ranking[] = ['label' => 'Otros', 'value' => $others];

        // 🔥 1) actualizar mapa
        $this->dispatch('observatorio:map:update', mapId: $this->mapId, data: $dataByDept);

        // 🔥 2) actualizar ranking lateral
        $this->dispatch('observatorio:map:ranking', mapId: $this->mapId, ranking: $ranking);
    }
    public function render()
    {
        return view('livewire.public-interface.maps.providers-by-department-map', [
            'geojsonUrl' => asset('geo/paraguay-departamentos.json'),
        ]);
    }
}
