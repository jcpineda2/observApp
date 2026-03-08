<?php

namespace App\Models;

use App\Enums\Season;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccommodationPerformance extends Model
{
    /** @use HasFactory<\Database\Factories\AccommodationPerformanceFactory> */
    use HasFactory;

    protected $fillable = [
        'year_id',
        'month_id',
        'state_id',
        'occupancy_rate',
        'season',
    ];

    protected $casts = [
        'year_id' => 'integer',
        'month_id' => 'integer',
        'state_id' => 'integer',
        'occupancy_rate' => 'decimal:2',
        'season' => Season::class,
    ];

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }

    public function month(): BelongsTo
    {
        return $this->belongsTo(Month::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }
}
