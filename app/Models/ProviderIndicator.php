<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderIndicator extends Model
{
    use HasFactory;

    protected $fillable = [
        'year_id',
        'total_providers',
        'new_registrations',
        'cancellations',
        'formalization_rate'
    ];
}
