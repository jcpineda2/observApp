<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AccommodationCapacity extends Model
{
    /** @use HasFactory<\Database\Factories\AccommodationCapacityFactory> */
    use HasFactory;

    protected $fillable = [
        'accommodation_category_id',
        'state_id',
        'establishments_count',
        'rooms_count',
        'beds_count',
    ];

    protected $casts = [
        'accommodation_category_id' => 'integer',
        'state_id' => 'integer',
        'establishments_count' => 'integer',
        'rooms_count' => 'integer',
        'beds_count' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(AccommodationCategory::class, 'accommodation_category_id');
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }
}
