<?php

namespace App\Livewire\Public;

use App\Actions\Public\GetEmploymentDashboard;
use App\Data\Public\FiltersData;
use App\Models\Year;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.public')]
class EmploymentPage extends Component
{
    public ?int $year = null;

    public array $kpis = [];
    public array $byServiceSector = [];
    public array $trend = [];
    public array $yoyTrend = [];
    public array $byGender = [];
    public array $byAge = [];
    public array $genderByServiceSector = [];

    protected $listeners = [
        'public-filters-updated' => 'onFiltersUpdated',
    ];

    public function mount(GetEmploymentDashboard $dashboard): void
    {
        $this->year ??= Year::query()
            ->orderByDesc('year')
            ->value('id');

        $this->loadAll($dashboard);
    }

    public function onFiltersUpdated($year, $month, GetEmploymentDashboard $dashboard): void
    {
        $this->year = $year ?: null;

        // Empleo no usa filtro de mes.
        $this->loadAll($dashboard);
    }

    private function loadAll(GetEmploymentDashboard $dashboard): void
    {
        $data = $dashboard->handle(
            new FiltersData(
                year: $this->year,
                month: null,
            )
        );

        $payload = $data->toArray();

        $this->kpis = $payload['kpis'];
        $this->byServiceSector = $payload['byServiceSector'];
        $this->trend = $payload['trend'];
        $this->yoyTrend = $payload['yoyTrend'];
        $this->byGender = $payload['byGender'];
        $this->byAge = $payload['byAge'];
        $this->genderByServiceSector = $payload['genderByServiceSector'];
    }

    public function render()
    {
        return view('livewire.public.employment-page');
    }
}
