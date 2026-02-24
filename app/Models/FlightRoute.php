<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FlightRoute extends Model
{
    /** @use HasFactory<\Database\Factories\FlightRouteFactory> */
    use HasFactory;

    protected $fillable = [
        'air_line_id',
        'origin_airport_id',
        'destination_airport_id',
        'is_active'
    ];
    public function airLine(): BelongsTo {
        return $this->belongsTo(AirLine::class);
    }

    public function origin(): BelongsTo {
        return $this->belongsTo(Airport::class, 'origin_airport_id');
    }

    public function destination(): BelongsTo {
        return $this->belongsTo(Airport::class, 'destination_airport_id');
    }
}
