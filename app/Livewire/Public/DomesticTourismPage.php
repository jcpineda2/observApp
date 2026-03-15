<?php

namespace App\Livewire\Public;

use App\Actions\Public\GetDomesticTourismDashboard;
use App\Data\Public\FiltersData;
use App\Models\Year;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.public')]
class DomesticTourismPage extends Component
{
    public ?int $year = null;
    public ?int $month = null;

    public array $kpis = [];
    public array $fixedComposition = [];
    public array $touristsByMonth = [];
    public array $spendObservedByMonth = [];
    public array $averageStayObservedByMonth = [];
    public array $byDestinationDepartment = [];
    public array $byOriginRegion = [];
    public array $byTravelReason = [];

    protected $listeners = [
        'public-filters-updated' => 'onFiltersUpdated',
    ];

    public function mount(GetDomesticTourismDashboard $dashboard): void
    {
        $this->year ??= Year::query()
            ->orderByDesc('year')
            ->value('id');

        $this->loadAll($dashboard);
    }

    public function onFiltersUpdated($year, $month, GetDomesticTourismDashboard $dashboard): void
    {
        $this->year = $year ?: null;
        $this->month = $month ?: null;

        $this->loadAll($dashboard);
    }

    private function loadAll(GetDomesticTourismDashboard $dashboard): void
    {
        $data = $dashboard->handle(
            new FiltersData(
                year: $this->year,
                month: $this->month,
            )
        );

        $payload = $data->toArray();

        $this->kpis = $payload['kpis'];
        $this->fixedComposition = $payload['fixedComposition'];
        $this->touristsByMonth = $payload['touristsByMonth'];
        $this->spendObservedByMonth = $payload['spendObservedByMonth'];
        $this->averageStayObservedByMonth = $payload['averageStayObservedByMonth'];
        $this->byDestinationDepartment = $payload['byDestinationDepartment'];
        $this->byOriginRegion = $payload['byOriginRegion'];
        $this->byTravelReason = $payload['byTravelReason'];
    }

    public function render()
    {
        return view('livewire.public.domestic-tourism-page');
    }
}
