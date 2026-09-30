<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reservation extends Model
{
    protected $fillable = [
        'student_id',
        'menu_id',
        'status',
        'reserved_at',
        'cancelled_at',
    ];

    protected $casts = [
        'reserved_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function mealDistribution(): HasOne
    {
        return $this->hasOne(MealDistribution::class);
    }
}

