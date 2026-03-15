<?php

namespace App\Data\Public;

final class InboundTourismDashboardData
{
    public function __construct(
        public readonly array $kpis = [],
        public readonly array $byMonth = [],
        public readonly array $byCountry = [],
        public readonly array $byEntryMode = [],
        public readonly array $byTravelReason = [],
        public readonly array $topMarkets = [],
        public readonly array $yoy = [],
        public readonly array $mapByDepartment = [],
    ) {}

    public function toArray(): array
    {
        return [
            'kpis' => $this->kpis,
            'byMonth' => $this->byMonth,
            'byCountry' => $this->byCountry,
            'byEntryMode' => $this->byEntryMode,
            'byTravelReason' => $this->byTravelReason,
            'topMarkets' => $this->topMarkets,
            'yoy' => $this->yoy,
            'mapByDepartment' => $this->mapByDepartment,
        ];
    }
}
