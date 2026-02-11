<?php

namespace App\Models;

use Altwaireb\Countries\Models\Country as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{

    use HasFactory;
    public function inboundTourisms(): HasMany {
        // FK personalizada porque en la tabla se llama 'residence_country_id'
        return $this->hasMany(InboundTourism::class, 'residence_country_id');
    }
}
