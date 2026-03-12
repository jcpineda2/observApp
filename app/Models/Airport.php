<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use App\Enums\Scope;
use App\Models\Concerns\Auditable;

class Airport extends Model
{
    /** @use HasFactory<\Database\Factories\AirportFactory> */
    use HasFactory;
    use Auditable;

    protected $fillable = [
        'name',
        'country_id',
        'city_id',
        'scope',
        'is_operational'
    ];

    protected $casts = [
        'country_id' => 'integer',
        'city_id' => 'integer',
        'is_operational' => 'boolean',
        'scope' => Scope::class,
    ];


    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Str::ucfirst(Str::lower($value)),
        );
    }

    // Vuelos que SALEN de este aeropuerto
    public function departures(): HasMany
    {
        return $this->hasMany(AirConnectivityRoute::class, 'origin_airport_id');
    }

    // Vuelos que LLEGAN a este aeropuerto
    public function arrivals(): HasMany
    {
        return $this->hasMany(AirConnectivityRoute::class, 'destination_airport_id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
