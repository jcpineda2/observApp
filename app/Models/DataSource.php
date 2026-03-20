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
        'code',
        'type',
        'description',
        'owner',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function runs(): HasMany
    {
        return $this->hasMany(DataSourceRun::class);
    }
}
