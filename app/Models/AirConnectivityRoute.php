<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AirConnectivityRoute extends Model
{
    use HasFactory;

    protected $fillable = [
        'year_id',
        'month_id',
        'air_line_id',
        'origin_airport_id',
        'destination_airport_id',
        'is_active',
        'flights_count',
        'seats_count',
    ];

    protected $casts = [
        'year_id' => 'integer',
        'month_id' => 'integer',
        'air_line_id' => 'integer',
        'origin_airport_id' => 'integer',
        'destination_airport_id' => 'integer',
        'is_active' => 'boolean',
        'flights_count' => 'integer',
        'seats_count' => 'integer',
    ];

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }

    public function month(): BelongsTo
    {
        return $this->belongsTo(Month::class);
    }

    public function airLine(): BelongsTo
    {
        return $this->belongsTo(AirLine::class);
    }

    public function originAirport(): BelongsTo
    {
        return $this->belongsTo(Airport::class, 'origin_airport_id');
    }

    public function destinationAirport(): BelongsTo
    {
        return $this->belongsTo(Airport::class, 'destination_airport_id');
    }
}
