<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
