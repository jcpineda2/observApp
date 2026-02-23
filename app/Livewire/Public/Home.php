<?php

namespace App\Livewire\Public;

use App\Models\DomesticTourism;
use App\Models\InboundTourism;
use App\Models\Year;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        // Indicadores “rápidos” (caché para no castigar DB)
        $stats = Cache::remember('public_home_stats', now()->addMinutes(10), function () {
            $latestYearId = Year::query()->max('id');

            $inboundArrivals = InboundTourism::query()
                ->when($latestYearId, fn ($q) => $q->where('year_id', $latestYearId))
                ->sum('tourist_arrivals');

            $domesticQty = DomesticTourism::query()
                ->when($latestYearId, fn ($q) => $q->where('year_id', $latestYearId))
                ->sum('tourist_quantity');

            return [
                'latest_year_id' => $latestYearId,
                'inbound_arrivals' => (int) $inboundArrivals,
                'domestic_tourists' => (int) $domesticQty,
            ];
        });

        return view('livewire.public.home', compact('stats'))
            ->layout('layouts.public', ['title' => 'Observatorio Turístico - SENATUR']);
    }
}
