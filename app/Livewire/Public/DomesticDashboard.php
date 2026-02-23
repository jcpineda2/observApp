<?php

namespace App\Livewire\Public;

use App\Models\DomesticTourism;
use App\Models\Month;
use App\Models\State;
use App\Models\Year;
use Livewire\Attributes\Url;
use Livewire\Component;

class DomesticDashboard extends Component
{
    #[Url] public ?int $yearId = null;
    #[Url] public ?int $monthId = null;
    #[Url] public ?int $departmentId = null;

    public function mount(): void
    {
        $this->yearId ??= Year::query()->max('id');
    }

    public function render()
    {
        $years = Year::query()->orderByDesc('year')->get(['id', 'year']);
        $months = Month::query()->orderBy('month_number')->get(['id', 'month', 'month_number']);
        $departments = State::query()->orderBy('name')->get(['id', 'name']);

        $query = DomesticTourism::query()
            ->when($this->yearId, fn ($q) => $q->where('year_id', $this->yearId))
            ->when($this->monthId, fn ($q) => $q->where('month_id', $this->monthId))
            ->when($this->departmentId, fn ($q) => $q->where('destination_department_id', $this->departmentId));

        $totals = (clone $query)
            ->selectRaw('
                COALESCE(SUM(tourist_quantity),0) as tourist_quantity,
                COALESCE(SUM(total_spend),0) as total_spend,
                COALESCE(AVG(average_stay),0) as average_stay
            ')
            ->first();

        $topDepartments = (clone $query)
            ->with('department:id,name')
            ->selectRaw('destination_department_id, SUM(tourist_quantity) as total')
            ->groupBy('destination_department_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('livewire.public.domestic-dashboard', compact(
            'years', 'months', 'departments', 'totals', 'topDepartments'
        ))->layout('layouts.public', ['title' => 'Turismo Interno - Observatorio']);
    }
}
