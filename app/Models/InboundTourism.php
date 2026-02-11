<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InboundTourism extends Model
{
    use HasFactory;

    protected $fillable = [
        'year_id',
        'month_id',
        'residence_country_id',
        'entry_mode_id',
        'travel_reason_id',
        'tourist_arrivals',
        'excursionist_arrivals',
        'foreign_exchange_revenue',
        'average_spend',
        'average_stay'
    ];

    public function country(): BelongsTo{
        return $this->belongsTo(Country::class, 'residence_country_id');
    }

    public function year(): BelongsTo {
        return $this->belongsTo(Year::class);
    }

    public function month(): BelongsTo {
        return $this->belongsTo(Month::class);
    }

    public function entryMode(): BelongsTo {
        return $this->belongsTo(EntryMode::class);
    }

    public function travelReason(): BelongsTo {
        return $this->belongsTo(TravelReason::class);
    }
}
