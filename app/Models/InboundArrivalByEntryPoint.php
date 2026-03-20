<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InboundArrivalByEntryPoint extends Model
{
    use HasFactory;
    use Auditable;

    protected $fillable = [
        'report_period_id',
        'entry_point_id',
        'tourist_arrivals',
        'data_source_run_id',
        'source_note',
    ];

    protected $casts = [
        'report_period_id' => 'integer',
        'entry_point_id' => 'integer',
        'tourist_arrivals' => 'integer',
        'data_source_run_id' => 'integer',
    ];

    public function getAuditModuleName(): string
    {
        return 'Receptivo por Punto de Entrada';
    }

    public function reportPeriod(): BelongsTo
    {
        return $this->belongsTo(ReportPeriod::class);
    }

    public function entryPoint(): BelongsTo
    {
        return $this->belongsTo(EntryPoint::class);
    }

    public function dataSourceRun(): BelongsTo
    {
        return $this->belongsTo(DataSourceRun::class);
    }
}
