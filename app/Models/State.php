<?php

namespace App\Models;

use Altwaireb\Countries\Models\State as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function providers(): HasMany {
        return $this->hasMany(TourismProviderStat::class);
    }

    public function domesticTourisms(): HasMany {
        // FK personalizada: 'destination_department_id'
        return $this->hasMany(DomesticTourism::class, 'destination_department_id');
    }
}
