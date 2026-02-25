<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DomesticTourism extends Model
{
    /** @use HasFactory<\Database\Factories\DomesticTourismFactory> */
    use HasFactory;

    protected $fillable = [
        'year_id',
        'month_id',
        'destination_department_id',
        'travel_reason_id',
        'origin_region',
        'tourist_quantity',
        'total_spend',
        'average_stay',
        'spend_composition'
    ];

    protected $casts = [
        'tourist_quantity' => 'integer',
        'total_spend' => 'decimal:2',
        'average_stay' => 'decimal:2',
    ];

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }

    public function month(): BelongsTo
    {
        return $this->belongsTo(Month::class);
    }

    public function destinationDepartment(): BelongsTo
    {
        return $this->belongsTo(State::class, 'destination_department_id');
    }

    public function travelReason(): BelongsTo
    {
        return $this->belongsTo(TravelReason::class);
    }
}
