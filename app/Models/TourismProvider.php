<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourismProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_sector_id',
        'state_id',
        'registration_date',
        'status'
    ];
}
