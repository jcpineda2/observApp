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
        'report_period_id',
        'name',
        'source_file_name',
        'source_file_path',
        'source_sheet_name',
        'external_reference',
        'source_url',
        'checksum',
        'extracted_at',
        'imported_at',
        'validated_at',
        'imported_by',
        'validated_by',
        'status',
        'notes',
    ];

    protected $casts = [
        'data_source_id' => 'integer',
        'report_period_id' => 'integer',
        'imported_by' => 'integer',
        'validated_by' => 'integer',
        'extracted_at' => 'datetime',
        'imported_at' => 'datetime',
        'validated_at' => 'datetime',
    ];

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
