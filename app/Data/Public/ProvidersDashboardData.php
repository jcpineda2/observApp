<?php

namespace App\Data\Public;

final class ProvidersDashboardData
{
    public function __construct(
        public readonly array $kpis = [],
        public readonly array $registrationsCancellationsByMonth = [],
        public readonly array $yoyStockByMonth = [],
        public readonly array $formalizationByMonth = [],
        public readonly array $byServiceSector = [],
        public readonly array $byDepartment = [],
    ) {}

    public function toArray(): array
    {
        return [
            'kpis' => $this->kpis,
            'registrationsCancellationsByMonth' => $this->registrationsCancellationsByMonth,
            'yoyStockByMonth' => $this->yoyStockByMonth,
            'formalizationByMonth' => $this->formalizationByMonth,
            'byServiceSector' => $this->byServiceSector,
            'byDepartment' => $this->byDepartment,
        ];
    }
}
