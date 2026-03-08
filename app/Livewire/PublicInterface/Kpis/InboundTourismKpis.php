<?php

namespace App\Livewire\PublicInterface\Kpis;

use App\Enums\IndicatorDomain;
use App\Enums\IndicatorKey;
use App\Models\InboundTourism;
use App\Models\IndicatorConstant;
use App\Models\Year;
use Livewire\Component;

class InboundTourismKpis extends Component
{
    public ?int $year = null;
    public ?int $month = null;

    public int $tourists = 0;
    public int $excursionists = 0;
    public float $foreignExchangeRevenue = 0.0;

    public ?float $fixedAverageSpend = null;
    public ?float $fixedAverageStay = null;

    public ?string $fixedAverageSpendUnit = null;
    public ?string $fixedAverageStayUnit = null;

    public ?string $fixedAverageSpendSource = null;
    public ?string $fixedAverageStaySource = null;

    protected $listeners = [
        'public-filters-updated' => 'onFiltersUpdated',
    ];

    public function mount(): void
    {
        if (! $this->year) {
            $this->year = Year::query()->orderByDesc('year')->value('id');
        }

        $this->recalculate();
    }

    public function onFiltersUpdated($year, $month): void
    {
        $this->year = $year ?: null;
        $this->month = $month ?: null;

        $this->recalculate();
    }

    private function baseQuery()
    {
        return InboundTourism::query()
            ->when($this->year, fn ($query) => $query->where('year_id', $this->year))
            ->when($this->month, fn ($query) => $query->where('month_id', $this->month));
    }

    private function recalculate(): void
    {
        if (! $this->year) {
            $this->resetKpis();
            return;
        }

        $query = $this->baseQuery();

        $this->tourists = (int) (clone $query)->sum('tourist_arrivals');

        $this->excursionists = (int) (clone $query)->sum('excursionist_arrivals');

        $this->foreignExchangeRevenue = round(
            (float) ((clone $query)->sum('foreign_exchange_revenue') ?? 0),
            2
        );

        $avgSpend = $this->resolveConstant(
            IndicatorDomain::Inbound,
            IndicatorKey::AvgSpendFixed
        );

        $avgStay = $this->resolveConstant(
            IndicatorDomain::Inbound,
            IndicatorKey::AvgStayFixed
        );

        $this->fixedAverageSpend = $avgSpend?->value;
        $this->fixedAverageSpendUnit = $avgSpend?->unit;
        $this->fixedAverageSpendSource = $avgSpend?->source;

        $this->fixedAverageStay = $avgStay?->value;
        $this->fixedAverageStayUnit = $avgStay?->unit;
        $this->fixedAverageStaySource = $avgStay?->source;
    }

    private function resolveConstant(IndicatorDomain $domain, IndicatorKey $key): ?object
    {
        if (! $this->year) {
            return null;
        }

        $row = IndicatorConstant::query()
            ->where('domain', $domain->value)
            ->where('key', $key->value)
            ->where(function ($query) {
                $query->where('year_id', $this->year)
                    ->orWhereNull('year_id');
            })
            ->orderByRaw('CASE WHEN year_id = ? THEN 0 ELSE 1 END', [$this->year])
            ->first();

        if (! $row) {
            return null;
        }

        return (object) [
            'value' => (float) $row->value,
            'unit' => $row->unit,
            'source' => $row->source,
        ];
    }

    private function resetKpis(): void
    {
        $this->tourists = 0;
        $this->excursionists = 0;
        $this->foreignExchangeRevenue = 0.0;

        $this->fixedAverageSpend = null;
        $this->fixedAverageStay = null;

        $this->fixedAverageSpendUnit = null;
        $this->fixedAverageStayUnit = null;

        $this->fixedAverageSpendSource = null;
        $this->fixedAverageStaySource = null;
    }

    public function render()
    {
        return view('livewire.public-interface.kpis.inbound-tourism-kpis');
    }
}
