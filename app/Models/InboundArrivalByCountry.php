<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InboundArrivalByCountry extends Model
{
    use HasFactory;
    use Auditable;

    protected $fillable = [
        'report_period_id',
        'country_id',
        'tourist_arrivals',
        'data_source_run_id',
        'source_note',
    ];

    protected $casts = [
        'report_period_id' => 'integer',
        'country_id' => 'integer',
        'tourist_arrivals' => 'integer',
        'data_source_run_id' => 'integer',
    ];

    public function getAuditModuleName(): string
    {
        return 'Receptivo por País';
    }

    public function reportPeriod(): BelongsTo
    {
        return $this->belongsTo(ReportPeriod::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function dataSourceRun(): BelongsTo
    {
        return $this->belongsTo(DataSourceRun::class);
    }
}
