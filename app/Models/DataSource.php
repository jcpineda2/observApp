<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DataSource extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'source_type',
        'provider_name',
        'system_name',
        'base_url',
        'description',
        'settings',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    //Relaciones con otros modelos
    public function runs(): HasMany
    {
        return $this->hasMany(DataSourceRun::class);
    }
}
