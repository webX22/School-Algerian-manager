<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Menu extends Model
{
    protected $fillable = [
        'service_date',
        'service_time',
        'planned_quantity',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'service_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function dishes(): BelongsToMany
    {
        return $this->belongsToMany(
            Dish::class,
            'menu_dish'
        );
    }

    public function mealDistributions()
    {
        return $this->hasMany(
            MealDistribution::class
        );
    }

    public function reservations()
    {
        return $this->hasMany(
            Reservation::class
        );
    }
}
