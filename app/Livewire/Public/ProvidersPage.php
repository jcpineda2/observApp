<?php

namespace App\Livewire\Public;

use App\Actions\Public\GetProvidersDashboard;
use App\Data\Public\FiltersData;
use App\Models\Year;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.public')]
class ProvidersPage extends Component
{
    public ?int $year = null;
    public ?int $month = null;

    public array $kpis = [];
    public array $registrationsCancellationsByMonth = [];
    public array $yoyStockByMonth = [];
    public array $formalizationByMonth = [];
    public array $byServiceSector = [];
    public array $byDepartment = [];

    protected $listeners = [
        'public-filters-updated' => 'onFiltersUpdated',
    ];

    public function mount(GetProvidersDashboard $dashboard): void
    {
        $this->year ??= Year::query()
            ->orderByDesc('year')
            ->value('id');

        $this->loadAll($dashboard);
    }

    public function onFiltersUpdated($year, $month, GetProvidersDashboard $dashboard): void
    {
        $this->year = $year ?: null;
        $this->month = $month ?: null;

        $this->loadAll($dashboard);
    }

    private function loadAll(GetProvidersDashboard $dashboard): void
    {
        $data = $dashboard->handle(
            new FiltersData(
                year: $this->year,
                month: $this->month,
            )
        );

        $payload = $data->toArray();

        $this->kpis = $payload['kpis'];
        $this->registrationsCancellationsByMonth = $payload['registrationsCancellationsByMonth'];
        $this->yoyStockByMonth = $payload['yoyStockByMonth'];
        $this->formalizationByMonth = $payload['formalizationByMonth'];
        $this->byServiceSector = $payload['byServiceSector'];
        $this->byDepartment = $payload['byDepartment'];
    }

    public function getActiveYearLabelProperty(): ?string
    {
        if (! $this->year) {
            return null;
        }

        return (string) \App\Models\Year::query()->whereKey($this->year)->value('year');
    }

    public function getActiveMonthLabelProperty(): ?string
    {
        if (! $this->month) {
            return null;
        }

        return \App\Models\Month::query()->whereKey($this->month)->value('month');
    }



    public function render()
    {
        return view('livewire.public.providers-page');
    }
}
