<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Accommodation extends Model
{
    /** @use HasFactory<\Database\Factories\AccommodationFactory> */
    use HasFactory;

    protected $fillable = [
        'accommodation_category_id',
        'state_id',
        'establishments_count',
        'rooms_count',
        'beds_count'
    ];

    public function category(): BelongsTo{
        return $this->belongsTo(AccommodationCategory::class, 'accommodation_category_id');
    }

    public function department(): BelongsTo {
        return $this->belongsTo(State::class);
    }

    // Relación con su desempeño mensual
    public function performances(): HasMany {
        return $this->hasMany(AccommodationPerformance::class);
    }
}

