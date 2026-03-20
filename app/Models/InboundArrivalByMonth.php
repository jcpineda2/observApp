<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InboundArrivalByMonth extends Model
{
    use HasFactory;
    use Auditable;

    protected $fillable = [
        'year_id',
        'month_id',
        'tourist_arrivals',
        'data_source_run_id',
        'source_note',
    ];

    protected $casts = [
        'year_id' => 'integer',
        'month_id' => 'integer',
        'tourist_arrivals' => 'integer',
        'data_source_run_id' => 'integer',
    ];

    public function getAuditModuleName(): string
    {
        return 'Receptivo por Mes';
    }

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }

    public function month(): BelongsTo
    {
        return $this->belongsTo(Month::class);
    }

    public function dataSourceRun(): BelongsTo
    {
        return $this->belongsTo(DataSourceRun::class);
    }
}
