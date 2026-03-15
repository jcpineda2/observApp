<?php

namespace App\Livewire\Public;

use App\Actions\Public\GetConnectivityDashboard;
use App\Data\Public\FiltersData;
use App\Models\Year;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.public')]
class ConnectivityPage extends Component
{
    public ?int $year = null;
    public ?int $month = null;

    public array $kpis = [];
    public array $flightsSeatsByMonth = [];
    public array $topAirlinesBySeats = [];
    public array $topRoutes = [];
    public array $topOriginAirports = [];
    public array $topDestinationAirports = [];
    public array $destinationsByCountry = [];
    public array $destinationsByCity = [];

    protected $listeners = [
        'public-filters-updated' => 'onFiltersUpdated',
    ];

    public function mount(GetConnectivityDashboard $dashboard): void
    {
        $this->year ??= Year::query()->orderByDesc('year')->value('id');

        $this->loadAll($dashboard);
    }

    public function onFiltersUpdated($year, $month, GetConnectivityDashboard $dashboard): void
    {
        $this->year = $year ?: null;
        $this->month = $month ?: null;

        $this->loadAll($dashboard);
    }

    private function loadAll(GetConnectivityDashboard $dashboard): void
    {
        $data = $dashboard->handle(
            new FiltersData(
                year: $this->year,
                month: $this->month,
            )
        );

        $payload = $data->toArray();

        $this->kpis = $payload['kpis'];
        $this->flightsSeatsByMonth = $payload['flightsSeatsByMonth'];
        $this->topAirlinesBySeats = $payload['topAirlinesBySeats'];
        $this->topRoutes = $payload['topRoutes'];
        $this->topOriginAirports = $payload['topOriginAirports'];
        $this->topDestinationAirports = $payload['topDestinationAirports'];
        $this->destinationsByCountry = $payload['destinationsByCountry'];
        $this->destinationsByCity = $payload['destinationsByCity'];
    }

    public function render()
    {
        return view('livewire.public.connectivity-page');
    }
}
