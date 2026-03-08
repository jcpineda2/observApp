<?php

namespace App\Models;

use App\Enums\IndicatorDomain;
use App\Enums\IndicatorKey;
use App\Filament\Resources\IndicatorConstants\IndicatorConstantResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IndicatorConstant extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain',
        'year_id',
        'key',
        'value',
        'label',
        'unit',
        'source',
        'notes',
    ];

    protected $casts = [
        'domain' => IndicatorDomain::class,
        'key' => IndicatorKey::class,
        'value' => 'decimal:4',
    ];

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }
}
