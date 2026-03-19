<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Continent extends Model
{
    /** @use HasFactory<\Database\Factories\ContinentFactory> */
    use HasFactory;

    protected $fillable = [
        'continent',
    ];

    protected $casts = [
        'continent' => 'string',
    ];

    protected function continent(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Str::ucfirst(Str::lower($value)),
        );
    }

    //relaciones

    public function countries(): HasMany
    {
        return $this->hasMany(Country::class);
    }
}
