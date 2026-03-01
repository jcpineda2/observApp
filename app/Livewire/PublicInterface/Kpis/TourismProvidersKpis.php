<?php

namespace App\Livewire\PublicInterface\Kpis;

use App\Models\TourismProviderStat;
use App\Models\Year;
use Livewire\Component;

class TourismProvidersKpis extends Component
{
    public ?int $year = null;
    public ?int $month = null;

    public int $totalRegistered = 0;
    public int $registrations = 0;
    public int $cancellations = 0;
    public float $formalizationPct = 0.0;

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

    private function baseQuery()
    {
        return TourismProviderStat::query()
            ->when($this->year, fn ($q) => $q->where('year_id', $this->year))
            ->when($this->month, fn ($q) => $q->where('month_id', $this->month));
    }

    private function recalculate(): void
    {
        if (! $this->year) {
            $this->totalRegistered = 0;
            $this->registrations = 0;
            $this->cancellations = 0;
            $this->formalizationPct = 0;
            return;
        }

        $q = $this->baseQuery();

        // total_registered puede repetirse por sector+depto. Para “Total nacional” tomamos el MAX del período.
        // (porque total_registered representa “stock total” del sector/depto; sumar inflaría).
        $this->totalRegistered = (int) $q->clone()->max('total_registered');

        $this->registrations = (int) $q->clone()->sum('registrations');
        $this->cancellations = (int) $q->clone()->sum('cancellations');

        $formalized = (int) $q->clone()->sum('formalized_total');
        $total = max(1, $this->totalRegistered);

        $this->formalizationPct = round(($formalized / $total) * 100, 2);
    }

    public function render()
    {
        return view('livewire.public-interface.kpis.tourism-providers-kpis');
    }
}
