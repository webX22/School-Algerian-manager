<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Dish extends Model
{
    protected $fillable = [
        'name',
        'description',
        'dish_type',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(
            Menu::class,
            'menu_dish'
        );
    }
}