<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Caravan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'vehicle_number',
        'description',
        'driver_name',
        'driver_phone',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function locations(): HasMany
    {
        return $this->hasMany(CaravanLocation::class)->orderBy('tracked_at', 'desc');
    }

    public function latestLocation()
    {
        return $this->hasOne(CaravanLocation::class)->latestOfMany('tracked_at');
    }
}

