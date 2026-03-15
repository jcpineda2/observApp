<?php

namespace App\Livewire\Public;

use App\Actions\Public\GetInboundDepartmentBreakdown;
use App\Actions\Public\GetInboundTourismDashboard;
use App\Data\Public\FiltersData;
use App\Models\Year;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.public')]
class InboundTourismPage extends Component
{
    public ?int $year = null;
    public ?int $month = null;

    public string $mapId = 'inbound-map-by-department';

    public ?string $selectedDepartment = null;
    public ?string $selectedDepartmentLabel = null;

    public array $kpis = [];
    public array $byMonth = [];
    public array $byCountry = [];
    public array $byEntryMode = [];
    public array $byTravelReason = [];
    public array $topMarkets = [];
    public array $yoy = [];
    public array $mapByDepartment = [];

    public array $selectedDepartmentSummary = [];
    public array $selectedDepartmentByCountry = [];

    protected $listeners = [
        'public-filters-updated' => 'onFiltersUpdated',
    ];

    public function mount(
        GetInboundTourismDashboard $dashboard,
        GetInboundDepartmentBreakdown $departmentBreakdown,
    ): void {
        $this->year ??= Year::query()
            ->orderByDesc('year')
            ->value('id');

        $this->loadAll($dashboard, $departmentBreakdown);
    }

    public function onFiltersUpdated(
        $year,
        $month,
        GetInboundTourismDashboard $dashboard,
        GetInboundDepartmentBreakdown $departmentBreakdown,
    ): void {
        $this->year = $year ?: null;
        $this->month = $month ?: null;

        $this->loadAll($dashboard, $departmentBreakdown);
    }

    public function selectDepartment(
        string $department,
        GetInboundDepartmentBreakdown $departmentBreakdown
    ): void {
        if ($this->selectedDepartment === $department) {
            $this->clearSelectedDepartment();

            return;
        }

        $this->selectedDepartment = $department;

        $this->loadSelectedDepartmentData($departmentBreakdown);

        $this->dispatch(
            'paraguay-map:update',
            mapId: $this->mapId,
            values: $this->mapByDepartment,
            selectedDepartment: $this->selectedDepartment,
        );
    }

    public function clearSelectedDepartment(): void
    {
        $this->selectedDepartment = null;
        $this->selectedDepartmentLabel = null;
        $this->selectedDepartmentSummary = [];
        $this->selectedDepartmentByCountry = [];

        $this->dispatch(
            'paraguay-map:update',
            mapId: $this->mapId,
            values: $this->mapByDepartment,
            selectedDepartment: null,
        );
    }

    private function loadAll(
        GetInboundTourismDashboard $dashboard,
        GetInboundDepartmentBreakdown $departmentBreakdown,
    ): void {
        $data = $dashboard->handle(
            new FiltersData(
                year: $this->year,
                month: $this->month,
            )
        );

        $payload = $data->toArray();

        $this->kpis = $payload['kpis'];
        $this->byMonth = $payload['byMonth'];
        $this->byCountry = $payload['byCountry'];
        $this->byEntryMode = $payload['byEntryMode'];
        $this->byTravelReason = $payload['byTravelReason'];
        $this->topMarkets = $payload['topMarkets'];
        $this->yoy = $payload['yoy'];
        $this->mapByDepartment = $payload['mapByDepartment'];

        $this->loadSelectedDepartmentData($departmentBreakdown);

        $this->dispatch(
            'paraguay-map:update',
            mapId: $this->mapId,
            values: $this->mapByDepartment,
            selectedDepartment: $this->selectedDepartment,
        );
    }

    private function loadSelectedDepartmentData(GetInboundDepartmentBreakdown $departmentBreakdown): void
    {
        $payload = $departmentBreakdown->handle(
            new FiltersData(
                year: $this->year,
                month: $this->month,
            ),
            $this->selectedDepartment,
        );

        $this->selectedDepartmentLabel = $payload['selectedDepartmentLabel'];
        $this->selectedDepartmentSummary = $payload['selectedDepartmentSummary'];
        $this->selectedDepartmentByCountry = $payload['selectedDepartmentByCountry'];
    }

    public function render()
    {
        return view('livewire.public.inbound-tourism-page');
    }
}
