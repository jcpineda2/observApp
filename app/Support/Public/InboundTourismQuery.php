<?php

namespace App\Support\Public;

use App\Data\Public\FiltersData;
use App\Models\InboundTourism;
use Illuminate\Database\Eloquent\Builder;

final class InboundTourismQuery
{
    public function base(FiltersData $filters): Builder
    {
        return InboundTourism::query()
            ->when($filters->year, fn (Builder $query) => $query->where('year_id', $filters->year))
            ->when($filters->month, fn (Builder $query) => $query->where('month_id', $filters->month));
    }

    /**
     * Query anual.
     * Ignora el filtro de mes para construir series completas del año.
     */
    public function byYear(FiltersData $filters): Builder
    {
        return InboundTourism::query()
            ->when($filters->year, fn (Builder $query) => $query->where('year_id', $filters->year));
    }
}
