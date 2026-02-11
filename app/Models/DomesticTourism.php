<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DomesticTourism extends Model
{
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
}
