<?php

namespace App\Livewire\Public;

use App\Models\Country;
use App\Models\EntryMode;
use App\Models\InboundTourism;
use App\Models\Month;
use App\Models\TravelReason;
use App\Models\Year;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Livewire\Component;

class InboundDashboard extends Component
{
    // filtros (Opción B: el usuario selecciona aquí, no en el menú)
    #[Url] public ?int $yearId = null;
    #[Url] public ?int $monthId = null;
    #[Url] public ?int $countryId = null;     // residence_country_id
    #[Url] public ?int $entryModeId = null;   // entry_mode_id
    #[Url] public ?int $reasonId = null;      // travel_reason_id

    public function mount(): void
    {
        // default: último año cargado
        $this->yearId ??= Year::query()->max('id');
    }

    protected function rules(): array
    {
        return [
            'yearId' => ['nullable', 'integer', 'exists:years,id'],
            'monthId' => ['nullable', 'integer', 'exists:months,id'],
            'countryId' => ['nullable', 'integer', 'exists:countries,id'],
            'entryModeId' => ['nullable', 'integer', 'exists:entry_modes,id'],
            'reasonId' => ['nullable', 'integer', 'exists:travel_reasons,id'],
        ];
    }

    public function updated($property): void
    {
        $this->validateOnly($property);
    }

    protected function baseQuery(): Builder
    {
        return InboundTourism::query()
            ->when($this->yearId, fn ($q) => $q->where('year_id', $this->yearId))
            ->when($this->monthId, fn ($q) => $q->where('month_id', $this->monthId))
            ->when($this->countryId, fn ($q) => $q->where('residence_country_id', $this->countryId))
            ->when($this->entryModeId, fn ($q) => $q->where('entry_mode_id', $this->entryModeId))
            ->when($this->reasonId, fn ($q) => $q->where('travel_reason_id', $this->reasonId));
    }

    public function render()
    {
        // combos
        $years = Year::query()->orderByDesc('year')->get(['id', 'year']);
        $months = Month::query()->orderBy('month_number')->get(['id', 'month', 'month_number']);

        // Ojo: si tu tabla countries usa otro campo (ej: "nombre"), ajusta aquí.
        $countries = Country::query()->orderBy('name')->get(['id', 'name']);

        $entryModes = EntryMode::query()->orderBy('description')->get(['id', 'description']);
        $reasons = TravelReason::query()->orderBy('description')->get(['id', 'description']);

        // indicadores (PDF: llegadas, excursionistas, divisas, gasto prom, estadía prom)
        $totals = (clone $this->baseQuery())
            ->selectRaw('
                COALESCE(SUM(tourist_arrivals),0) as tourist_arrivals,
                COALESCE(SUM(excursionist_arrivals),0) as excursionist_arrivals,
                COALESCE(SUM(foreign_exchange_revenue),0) as foreign_exchange_revenue,
                COALESCE(AVG(average_spend),0) as average_spend,
                COALESCE(AVG(average_stay),0) as average_stay
            ')
            ->first();

        // Ranking mercados emisores (Top países)
        $topCountries = (clone $this->baseQuery())
            ->with('country:id,name')
            ->selectRaw('residence_country_id, SUM(tourist_arrivals) as total')
            ->groupBy('residence_country_id')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // Aperturas: por vía de ingreso
        $byEntryMode = (clone $this->baseQuery())
            ->with('entryMode:id,description')
            ->selectRaw('entry_mode_id, SUM(tourist_arrivals) as total')
            ->groupBy('entry_mode_id')
            ->orderByDesc('total')
            ->get();

        // Aperturas: por motivo
        $byReason = (clone $this->baseQuery())
            ->with('travelReason:id,description')
            ->selectRaw('travel_reason_id, SUM(tourist_arrivals) as total')
            ->groupBy('travel_reason_id')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // Aperturas: por mes (útil para después graficar)
        $byMonth = (clone $this->baseQuery())
            ->with('month:id,month,month_number')
            ->selectRaw('month_id, SUM(tourist_arrivals) as total')
            ->groupBy('month_id')
            ->orderBy('month_id')
            ->get();

        return view('livewire.public.inbound-dashboard', compact(
            'years',
            'months',
            'countries',
            'entryModes',
            'reasons',
            'totals',
            'topCountries',
            'byEntryMode',
            'byReason',
            'byMonth'
        ))->layout('layouts.public', ['title' => 'Turismo Receptivo - Observatorio']);
    }
}
