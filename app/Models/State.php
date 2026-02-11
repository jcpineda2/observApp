<?php

namespace App\Models;

use Altwaireb\Countries\Models\State as Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    public function accommodations(): HasMany {
        return $this->hasMany(Accommodation::class);
    }

    public function providers(): HasMany {
        return $this->hasMany(TourismProvider::class);
    }

    public function domesticTourisms(): HasMany {
        // FK personalizada: 'destination_department_id'
        return $this->hasMany(DomesticTourism::class, 'destination_department_id');
    }
}
