<?php

namespace App\Livewire\Public;

use App\Actions\Public\GetAccommodationDashboard;
use App\Data\Public\FiltersData;
use App\Models\Year;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.public')]
class AccommodationPage extends Component
{
    public ?int $year = null;
    public ?int $month = null;

    public array $kpis = [];
    public array $occupancyByMonth = [];
    public array $occupancyYoYByMonth = [];
    public array $seasonVsOccupancy = [];
    public array $byCategory = [];
    public array $capacityByDepartment = [];

    protected $listeners = [
        'public-filters-updated' => 'onFiltersUpdated',
    ];

    public function mount(GetAccommodationDashboard $dashboard): void
    {
        $this->year ??= Year::query()
            ->orderByDesc('year')
            ->value('id');

        $this->loadAll($dashboard);
    }

    public function onFiltersUpdated($year, $month, GetAccommodationDashboard $dashboard): void
    {
        $this->year = $year ?: null;
        $this->month = $month ?: null;

        $this->loadAll($dashboard);
    }

    private function loadAll(GetAccommodationDashboard $dashboard): void
    {
        $data = $dashboard->handle(
            new FiltersData(
                year: $this->year,
                month: $this->month,
            )
        );

        $payload = $data->toArray();

        $this->kpis = $payload['kpis'];
        $this->occupancyByMonth = $payload['occupancyByMonth'];
        $this->occupancyYoYByMonth = $payload['occupancyYoYByMonth'];
        $this->seasonVsOccupancy = $payload['seasonVsOccupancy'];
        $this->byCategory = $payload['byCategory'];
        $this->capacityByDepartment = $payload['capacityByDepartment'];
    }

    public function render()
    {
        return view('livewire.public.accommodation-page');
    }
}
