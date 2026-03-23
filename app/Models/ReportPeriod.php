<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportPeriod extends Model
{
    /** @use HasFactory<\Database\Factories\ReportPeriodFactory> */
    use HasFactory;

    protected $fillable = [
        'year_id',
        'start_month_id',
        'end_month_id',
        'period_type',
        'period_key',
        'label',
        'is_full_year',
        'starts_at',
        'ends_at',
        'is_active'
    ];

    protected $casts = [
        'year_id' => 'integer',
        'start_month_id' => 'integer',
        'end_month_id' => 'integer',
        'label' => 'string',
        'is_full_year' => 'boolean',
        'is_active'
    ];

    //Relaciones con otros modelos

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }

    public function startMonth(): BelongsTo
    {
        return $this->belongsTo(Month::class, 'start_month_id');
    }

    public function endMonth(): BelongsTo
    {
        return $this->belongsTo(Month::class, 'end_month_id');
    }
}
