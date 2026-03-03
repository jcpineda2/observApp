<?php

namespace App\Livewire\PublicInterface\Kpis;

use App\Models\InboundTourism;
use App\Models\Year;
use Livewire\Component;

class InboundTourismKpis extends Component
{
    public ?int $year = null;
    public ?int $month = null;

    public int $tourists = 0;
    public int $excursionists = 0;
    public float $foreignExchange = 0.0;
    public float $avgSpend = 0.0;
    public float $avgStay = 0.0;

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
        return InboundTourism::query()
            ->when($this->year, fn($q) => $q->where('year_id', $this->year))
            ->when($this->month, fn($q) => $q->where('month_id', $this->month));
    }

    private function recalculate(): void
    {
        if (! $this->year) {
            $this->tourists = 0;
            $this->excursionists = 0;
            $this->foreignExchange = 0;
            $this->avgSpend = 0;
            $this->avgStay = 0;
            return;
        }

        $q = $this->baseQuery();

        $this->tourists = (int) $q->clone()->sum('tourist_arrivals');
        $this->excursionists = (int) $q->clone()->sum('excursionist_arrivals');
        $this->foreignExchange = (float) $q->clone()->sum('foreign_exchange_revenue');

        $this->avgSpend = (float) $q->clone()->avg('average_spend');
        $this->avgStay  = (float) $q->clone()->avg('average_stay');
    }

    public function render()
    {
        return view('livewire.public-interface.kpis.inbound-tourism-kpis');
    }
}
