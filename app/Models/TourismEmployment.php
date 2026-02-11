<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TourismEmployment extends Model
{
    use HasFactory;

    protected $fillable = [
        'year_id',
        'service_sector_id',
        'direct_employment',
        'national_participation',
        'interannual_variation'
    ];

    public function year(): BelongsTo {
        return $this->belongsTo(Year::class);
    }

    public function serviceSector(): BelongsTo {
        return $this->belongsTo(ServiceSector::class);
    }

    public function demographics(): HasMany {
    return $this->hasMany(EmploymentDemographic::class);
}
}
