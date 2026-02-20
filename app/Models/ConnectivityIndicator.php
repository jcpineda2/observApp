<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConnectivityIndicator extends Model
{
    /** @use HasFactory<\Database\Factories\ConnectivityIndicatorFactory> */
    use HasFactory;

    protected $fillable = [
        'year_id',
        'operating_airports',
        'connected_destinations',
        'active_routes'
    ];

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }
}
