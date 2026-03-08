<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class AccommodationCategory extends Model
{
    /** @use HasFactory<\Database\Factories\AccommodationCategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'category',
    ];

    protected function category(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Str::ucfirst(Str::lower($value)),
        );
    }

    public function capacities(): HasMany
    {
        return $this->hasMany(AccommodationCapacity::class, 'accommodation_category_id');
    }
}
