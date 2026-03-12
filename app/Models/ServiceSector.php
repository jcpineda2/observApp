<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ServiceSector extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceSectorFactory> */
    use HasFactory;
    use Auditable;

    protected $fillable = [
        'description',
    ];

    protected function description(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Str::ucfirst(Str::lower($value)),
        );
    }

    public function providers(): HasMany
    {
        return $this->hasMany(TourismProviderStat::class);
    }

    public function employments(): HasMany
    {
        return $this->hasMany(TourismEmployment::class);
    }
}
