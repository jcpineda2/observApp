<?php

namespace App\Livewire\PublicInterface\Kpis;

use App\Models\DomesticTourism;
use App\Models\Year;
use Livewire\Component;

class DomesticTourismKpis extends Component
{
    public ?int $year = null;   // year_id
    public ?int $month = null;  // month_id (opcional)

    public int $tourists = 0;
    public float $totalSpend = 0.0;

    // Estadía promedio (dos variantes)
    public float $avgStaySimple = 0.0;      // AVG(average_stay)
    public float $avgStayWeighted = 0.0;    // SUM(average_stay*tourist_quantity) / SUM(tourist_quantity)

    protected $listeners = [
        'public-filters-updated' => 'onFiltersUpdated',
    ];

    public function mount(): void
    {
        // Si no llega año, usamos el último disponible
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

    private function baseQuery()
    {
        return DomesticTourism::query()
            ->when($this->year, fn ($q) => $q->where('year_id', $this->year))
            ->when($this->month, fn ($q) => $q->where('month_id', $this->month));
    }

    private function recalculate(): void
    {
        if (! $this->year) {
            // Sin año, mostramos ceros (podríamos mostrar mensaje luego)
            $this->tourists = 0;
            $this->totalSpend = 0.0;
            $this->avgStaySimple = 0.0;
            $this->avgStayWeighted = 0.0;
            return;
        }

        $q = $this->baseQuery();

        $this->tourists = (int) $q->clone()->sum('tourist_quantity');
        $this->totalSpend = (float) $q->clone()->sum('total_spend');

        $this->avgStaySimple = (float) $q->clone()->avg('average_stay');

        $weighted = $q->clone()
            ->selectRaw('
                SUM(average_stay * tourist_quantity) as weighted_sum,
                SUM(tourist_quantity) as qty_sum
            ')
            ->first();

        $qty = (float) ($weighted->qty_sum ?? 0);
        $ws  = (float) ($weighted->weighted_sum ?? 0);

        $this->avgStayWeighted = $qty > 0 ? ($ws / $qty) : 0.0;
    }

    public function render()
    {
        return view('livewire.public-interface.kpis.domestic-tourism-kpis');
    }
}
