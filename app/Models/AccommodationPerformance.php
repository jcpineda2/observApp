<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccommodationPerformance extends Model
{
    /** @use HasFactory<\Database\Factories\AccommodationPerformanceFactory> */
    use HasFactory;

    protected $fillable = [
        'accommodation_id',
        'year_id',
        'month_id',
        'occupancy_rate',
        'season'
    ];

    public function accommodation(): BelongsTo
    {
        return $this->belongsTo(Accommodation::class);
    }

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }

    public function month(): BelongsTo
    {
        return $this->belongsTo(Month::class);
    }

}
