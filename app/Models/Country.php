<?php

namespace App\Models;

use Altwaireb\Countries\Models\Country as Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    public function inboundTourisms(): HasMany {
        // FK personalizada porque en la tabla se llama 'residence_country_id'
        return $this->hasMany(InboundTourism::class, 'residence_country_id');
    }
    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function airports(): HasMany
    {
        return $this->hasMany(Airport::class);
    }

}
