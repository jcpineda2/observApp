<?php

namespace App\Livewire\PublicInterface\Kpis;

use App\Models\TourismEmployment;
use App\Models\Year;
use Livewire\Component;

class TourismEmploymentKpis extends Component
{
    public ?int $year = null;
    public ?int $month = null; // se ignora (empleo es anual)

    public int $directEmploymentTotal = 0;
    public float $avgNationalParticipation = 0.0;
    public float $avgInterannualVariation = 0.0;
    public int $segmentsCount = 0;

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
        $this->month = $month ?: null; // anual

        $this->recalculate();
    }

    private function recalculate(): void
    {
        if (! $this->year) {
            $this->directEmploymentTotal = 0;
            $this->avgNationalParticipation = 0;
            $this->avgInterannualVariation = 0;
            $this->segmentsCount = 0;
            return;
        }

        $q = TourismEmployment::query()->where('year_id', $this->year);

        $this->directEmploymentTotal = (int) $q->sum('direct_employment');
        $this->avgNationalParticipation = round((float) $q->avg('national_participation'), 2);
        $this->avgInterannualVariation = round((float) $q->avg('interannual_variation'), 2);
        $this->segmentsCount = (int) $q->distinct('service_sector_id')->count('service_sector_id');
    }

    public function render()
    {
        return view('livewire.public-interface.kpis.tourism-employment-kpis');
    }
}
