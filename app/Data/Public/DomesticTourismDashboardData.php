<?php

namespace App\Data\Public;

final class DomesticTourismDashboardData
{
    public function __construct(
        public readonly array $kpis = [],
        public readonly array $fixedComposition = [],
        public readonly array $touristsByMonth = [],
        public readonly array $spendObservedByMonth = [],
        public readonly array $averageStayObservedByMonth = [],
        public readonly array $byDestinationDepartment = [],
        public readonly array $byOriginRegion = [],
        public readonly array $byTravelReason = [],
    ) {}

    public function toArray(): array
    {
        return [
            'kpis' => $this->kpis,
            'fixedComposition' => $this->fixedComposition,
            'touristsByMonth' => $this->touristsByMonth,
            'spendObservedByMonth' => $this->spendObservedByMonth,
            'averageStayObservedByMonth' => $this->averageStayObservedByMonth,
            'byDestinationDepartment' => $this->byDestinationDepartment,
            'byOriginRegion' => $this->byOriginRegion,
            'byTravelReason' => $this->byTravelReason,
        ];
    }
}
