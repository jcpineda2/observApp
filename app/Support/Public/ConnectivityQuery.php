<?php

namespace App\Support\Public;

use App\Data\Public\FiltersData;
use App\Models\AirConnectivityRoute;
use Illuminate\Database\Eloquent\Builder;

final class ConnectivityQuery
{
    public function base(FiltersData $filters): Builder
    {
        return AirConnectivityRoute::query()
            ->when($filters->year, fn (Builder $query) => $query->where('year_id', $filters->year))
            ->when($filters->month, fn (Builder $query) => $query->where('month_id', $filters->month));
    }

    public function byYear(FiltersData $filters): Builder
    {
        return AirConnectivityRoute::query()
            ->when($filters->year, fn (Builder $query) => $query->where('year_id', $filters->year));
    }
}
