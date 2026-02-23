<?php

namespace App\Livewire\Public;

use App\Models\InboundTourism;
use App\Models\Month;
use App\Models\Year;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Livewire\Component;

class InboundDashboard extends Component
{
    #[Url] public ?int $yearId = null;
    #[Url] public ?int $monthId = null;

    public function mount(): void
    {
        $this->yearId ??= Year::query()->max('id');
        // month opcional; si no se manda, mostramos agregado anual
    }

    protected function baseQuery(): Builder
    {
        return InboundTourism::query()
            ->when($this->yearId, fn ($q) => $q->where('year_id', $this->yearId))
            ->when($this->monthId, fn ($q) => $q->where('month_id', $this->monthId));
    }

    public function render()
    {
        $years = Year::query()->orderByDesc('year')->get(['id', 'year']);
        $months = Month::query()->orderBy('month_number')->get(['id', 'month', 'month_number']);

        $totals = (clone $this->baseQuery())
            ->selectRaw('
                COALESCE(SUM(tourist_arrivals),0) as tourist_arrivals,
                COALESCE(SUM(excursionist_arrivals),0) as excursionist_arrivals,
                COALESCE(SUM(foreign_exchange_revenue),0) as foreign_exchange_revenue,
                COALESCE(AVG(average_spend),0) as average_spend,
                COALESCE(AVG(average_stay),0) as average_stay
            ')
            ->first();

        $topCountries = (clone $this->baseQuery())
            ->with('country:id,name')   // asumiendo que el paquete countries tiene name
            ->selectRaw('residence_country_id, SUM(tourist_arrivals) as total')
            ->groupBy('residence_country_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('livewire.public.inbound-dashboard', compact('years', 'months', 'totals', 'topCountries'))
            ->layout('layouts.public', ['title' => 'Turismo Receptivo - Observatorio']);
    }
}
