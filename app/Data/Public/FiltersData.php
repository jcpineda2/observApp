<?php

namespace App\Data\Public;

final class FiltersData
{
    public function __construct(
        public readonly ?int $year = null,
        public readonly ?int $month = null,
    ) {}

    public function cacheSuffix(): string
    {
        return 'year_' . ($this->year ?? 'all') . ':month_' . ($this->month ?? 'all');
    }
}
