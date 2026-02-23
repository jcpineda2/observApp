<?php

namespace App\Livewire\Public;

use App\Models\DomesticTourism;
use App\Models\Month;
use App\Models\State;
use App\Models\TravelReason;
use App\Models\Year;
use Livewire\Attributes\Url;
use Livewire\Component;

class DomesticDashboard extends Component
{
    #[Url] public ?int $yearId = null;
    #[Url] public ?int $monthId = null;
    #[Url] public ?int $departmentId = null;
    #[Url] public ?int $reasonId = null;

    public function mount(): void
    {
        // si no llega en querystring, usamos el último año cargado
        $this->yearId ??= Year::query()->max('id');
    }

    public function render()
    {
        $years = Year::query()->orderByDesc('year')->get(['id', 'year']);
        $months = Month::query()->orderBy('month_number')->get(['id', 'month', 'month_number']);
        $departments = State::query()->orderBy('name')->get(['id', 'name']);
        $reasons = TravelReason::query()->orderBy('description')->get(['id', 'description']);

        $base = DomesticTourism::query()
            ->when($this->yearId, fn ($q) => $q->where('year_id', $this->yearId))
            ->when($this->monthId, fn ($q) => $q->where('month_id', $this->monthId))
            ->when($this->departmentId, fn ($q) => $q->where('destination_department_id', $this->departmentId))
            ->when($this->reasonId, fn ($q) => $q->where('travel_reason_id', $this->reasonId));

        $totals = (clone $base)
            ->selectRaw('
                COALESCE(SUM(tourist_quantity),0) as tourist_quantity,
                COALESCE(SUM(total_spend),0) as total_spend,
                COALESCE(AVG(average_stay),0) as average_stay
            ')
            ->first();

        $topDepartments = (clone $base)
            ->with('department:id,name')
            ->selectRaw('destination_department_id, SUM(tourist_quantity) as total')
            ->groupBy('destination_department_id')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return view('livewire.public.domestic-dashboard', compact(
            'years','months','departments','reasons','totals','topDepartments'
        ))->layout('layouts.public', ['title' => 'Turismo Interno - Observatorio']);
    }
}
