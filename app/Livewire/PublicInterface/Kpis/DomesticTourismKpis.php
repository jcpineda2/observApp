<?php

namespace App\Livewire\PublicInterface\Kpis;

use App\Models\DomesticTourism;
use App\Models\Year;
use Livewire\Component;

class DomesticTourismKpis extends Component
{
    public ?int $year = null;
    public ?int $month = null;

    public int $tourists = 0;
    public float $totalSpendObserved = 0.0;
    public float $avgStayObserved = 0.0;

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

    private function baseQuery()
    {
        return DomesticTourism::query()
            ->when($this->year, fn ($query) => $query->where('year_id', $this->year))
            ->when($this->month, fn ($query) => $query->where('month_id', $this->month));
    }

    private function recalculate(): void
    {
        if (! $this->year) {
            $this->resetKpis();
            return;
        }

        $query = $this->baseQuery();

        $this->tourists = (int) (clone $query)->sum('tourist_quantity');

        $this->totalSpendObserved = round(
            (float) ((clone $query)->sum('total_spend') ?? 0),
            2
        );

        $this->avgStayObserved = round(
            (float) ((clone $query)->avg('average_stay') ?? 0),
            2
        );
    }

    private function resetKpis(): void
    {
        $this->tourists = 0;
        $this->totalSpendObserved = 0.0;
        $this->avgStayObserved = 0.0;
    }

    public function render()
    {
        return view('livewire.public-interface.kpis.domestic-tourism-kpis');
    }
}
