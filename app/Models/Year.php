<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Year extends Model
{
    /** @use HasFactory<\Database\Factories\YearFactory> */
    use HasFactory;

    protected $fillable = [
        'year',
    ];

    public function inboundTourisms(): HasMany {
        return $this->hasMany(InboundTourism::class);
    }

    public function domesticTourisms(): HasMany {
        return $this->hasMany(DomesticTourism::class);
    }

    public function tourismEmployments(): HasMany {
        return $this->hasMany(TourismEmployment::class);
    }
    public function accommodationPerformances(): HasMany
    {
        return $this->hasMany(AccommodationPerformance::class);
    }

    public function connectivityIndicators(): HasMany
    {
        return $this->hasMany(ConnectivityIndicator::class);
    }

    public function providerIndicators(): HasMany
    {
        return $this->hasMany(ProviderIndicator::class);
    }
}
