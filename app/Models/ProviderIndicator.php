<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProviderIndicator extends Model
{
    /** @use HasFactory<\Database\Factories\ProviderIndicatorFactory> */
    use HasFactory;

    protected $fillable = [
        'year_id',
        'total_providers',
        'new_registrations',
        'cancellations',
        'formalization_rate'
    ];

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }
}
