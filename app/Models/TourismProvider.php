<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourismProvider extends Model
{
    /** @use HasFactory<\Database\Factories\TourismProviderFactory> */
    use HasFactory;

    protected $fillable = [
        'service_sector_id',
        'state_id',
        'registration_date',
        'status'
    ];

    protected $casts = [
        'status' => Status::class,
    ];


    public function serviceSector(): BelongsTo
    {
        return $this->belongsTo(ServiceSector::class);
    }

    public function department(): BelongsTo
    {
        // en tu BD se llama state_id pero conceptualmente es "departamento"
        return $this->belongsTo(State::class, 'state_id');
    }
}
