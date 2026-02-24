<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AirLine extends Model
{
    /** @use HasFactory<\Database\Factories\AirLineFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function flightRoutes(): HasMany
    {
        return $this->hasMany(FlightRoute::class, 'air_line_id');
    }
}
