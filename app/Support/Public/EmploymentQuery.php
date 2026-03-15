<?php

namespace App\Support\Public;

use App\Data\Public\FiltersData;
use App\Models\TourismEmployment;
use Illuminate\Database\Eloquent\Builder;

final class EmploymentQuery
{
    public function base(FiltersData $filters): Builder
    {
        return TourismEmployment::query()
            ->when($filters->year, fn (Builder $query) => $query->where('year_id', $filters->year));
    }

    /**
     * Serie histórica completa.
     * No aplica filtro de año porque justamente queremos ver toda la evolución.
     */
    public function historical(): Builder
    {
        return TourismEmployment::query();
    }
}
