<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    use HasFactory;

    protected $fillable = [
        'accommodation_category_id',
        'state_id',
        'establishments_count',
        'rooms_count',
        'beds_count'
    ];
}
