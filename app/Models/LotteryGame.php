<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LotteryGame extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'min_number',
        'max_number',
        'numbers_drawn',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function results(): HasMany
    {
        return $this->hasMany(LotteryResult::class);
    }

    public function predictions(): HasMany
    {
        return $this->hasMany(LotteryPrediction::class);
    }
}
