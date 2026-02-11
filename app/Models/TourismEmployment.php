<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourismEmployment extends Model
{
    use HasFactory;

    protected $fillable = [
        'year_id',
        'service_sector_id',
        'direct_employment',
        'national_participation',
        'interannual_variation'
    ];
}
