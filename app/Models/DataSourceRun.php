<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataSourceRun extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_source_id',
        'triggered_by_user_id',
        'report_period_id',
        'run_type',
        'status',
        'started_at',
        'finished_at',
        'records_read',
        'records_inserted',
        'records_updated',
        'records_failed',
        'error_summary',
        'meta',
    ];

    protected $casts = [
        'data_source_id' => 'integer',
        'triggered_by_user_id' => 'integer',
        'report_period_id' => 'integer',
    ];


    //Relaciones con otros modelos

    public function dataSource(): BelongsTo
    {
        return $this->belongsTo(DataSource::class);
    }

    public function reportPeriod(): BelongsTo
    {
        return $this->belongsTo(ReportPeriod::class);
    }

    public function importedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'imported_by');
    }

    public function validatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by');
    }
}
