<?php

namespace App\Livewire\PublicInterface;

use App\Models\Month;
use App\Models\Year;
use Livewire\Component;

class GlobalFilters extends Component
{
    public ?int $year = null;
    public ?int $month = null;

    // Opciones
    public array $yearOptions = [];
    public array $monthOptions = [];

    protected array $queryString = [
        'year'  => ['except' => null],
        'month' => ['except' => null],
    ];

    public function mount(): void
    {
        // Años disponibles (desc)
        $this->yearOptions = Year::query()
            ->orderByDesc('year')
            ->pluck('year', 'id')
            ->toArray();

        // Meses (ordenados)
        $this->monthOptions = Month::query()
            ->orderBy('month_number')
            ->get(['id', 'month', 'month_number'])
            ->mapWithKeys(fn ($m) => [$m->id => $m->month])
            ->toArray();

        // Si viene un "year" que no existe, lo anulamos
        if ($this->year && ! array_key_exists($this->year, $this->yearOptions)) {
            $this->year = null;
        }
        if ($this->month && ! array_key_exists($this->month, $this->monthOptions)) {
            $this->month = null;
        }

        // Avisar estado inicial al resto
        $this->dispatchFilters();
    }

    public function updatedYear(): void
    {
        $this->dispatchFilters();
    }

    public function updatedMonth(): void
    {
        $this->dispatchFilters();
    }

    public function resetFilters(): void
    {
        $this->year = null;
        $this->month = null;

        $this->dispatchFilters();
    }

    protected function dispatchFilters(): void
    {
        // Evento global para que lo escuchen KPIGrid/ChartCard/etc.
        $this->dispatch('public-filters-updated', year: $this->year, month: $this->month);
    }

    public function render()
    {
        return view('livewire.public-interface.global-filters');
    }
}
