<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourismProviderStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'year_id',
        'month_id',
        'service_sector_id',
        'state_id',
        'total_registered',
        'registrations',
        'cancellations',
        'formalized_total',
    ];

    protected $casts = [
        'total_registered' => 'integer',
        'registrations' => 'integer',
        'cancellations' => 'integer',
        'formalized_total' => 'integer',
    ];

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }

    public function month(): BelongsTo
    {
        return $this->belongsTo(Month::class);
    }

    public function serviceSector(): BelongsTo
    {
        return $this->belongsTo(ServiceSector::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    // Para UI / dashboards: % formalización (0..100)
    public function getFormalizationPercentageAttribute(): float
    {
        if (($this->total_registered ?? 0) <= 0) {
            return 0.0;
        }

        return round(($this->formalized_total / $this->total_registered) * 100, 2);
    }
}
