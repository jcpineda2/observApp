<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccommodationPerformance extends Model
{
    use HasFactory;

    protected $fillable = [
        'accommodation_id',
        'year_id',
        'month_id',
        'occupancy_rate',
        'season'
    ];

}
