<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConnectivityIndicator extends Model
{
    use HasFactory;

    protected $fillable = [
        'year_id',
        'operating_airports',
        'connected_destinations',
        'active_routes'
    ];
}
