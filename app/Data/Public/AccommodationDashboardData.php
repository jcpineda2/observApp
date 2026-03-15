<?php

namespace App\Data\Public;

final class AccommodationDashboardData
{
    public function __construct(
        public readonly array $kpis = [],
        public readonly array $occupancyByMonth = [],
        public readonly array $occupancyYoYByMonth = [],
        public readonly array $seasonVsOccupancy = [],
        public readonly array $byCategory = [],
        public readonly array $capacityByDepartment = [],
    ) {}

    public function toArray(): array
    {
        return [
            'kpis' => $this->kpis,
            'occupancyByMonth' => $this->occupancyByMonth,
            'occupancyYoYByMonth' => $this->occupancyYoYByMonth,
            'seasonVsOccupancy' => $this->seasonVsOccupancy,
            'byCategory' => $this->byCategory,
            'capacityByDepartment' => $this->capacityByDepartment,
        ];
    }
}
