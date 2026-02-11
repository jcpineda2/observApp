<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Airport extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'country_id',
        'city_id'
    ];

    // Vuelos que SALEN de este aeropuerto
    public function departures(): HasMany{
        return $this->hasMany(FlightRoute::class, 'origin_airport_id');
    }

    // Vuelos que LLEGAN a este aeropuerto
    public function arrivals(): HasMany {
        return $this->hasMany(FlightRoute::class, 'destination_airport_id');
    }
}
