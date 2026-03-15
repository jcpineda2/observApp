<?php

namespace App\Data\Public;

final class EmploymentDashboardData
{
    public function __construct(
        public readonly array $kpis = [],
        public readonly array $byServiceSector = [],
        public readonly array $trend = [],
        public readonly array $yoyTrend = [],
        public readonly array $byGender = [],
        public readonly array $byAge = [],
        public readonly array $genderByServiceSector = [],
    ) {}

    public function toArray(): array
    {
        return [
            'kpis' => $this->kpis,
            'byServiceSector' => $this->byServiceSector,
            'trend' => $this->trend,
            'yoyTrend' => $this->yoyTrend,
            'byGender' => $this->byGender,
            'byAge' => $this->byAge,
            'genderByServiceSector' => $this->genderByServiceSector,
        ];
    }
}
