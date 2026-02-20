<?php

namespace App\Models;

use Altwaireb\Countries\Models\City as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function airports(): HasMany
    {
        return $this->hasMany(Airport::class);
    }
}
