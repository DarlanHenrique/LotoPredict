<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LotteryResult extends Model
{
    protected $fillable = [
        'lottery_game_id',
        'contest_number',
        'draw_date',
        'drawn_numbers',
        'extra_data',
    ];

    protected $casts = [
        'drawn_numbers' => 'array',
        'extra_data' => 'array',
        'draw_date' => 'date',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(LotteryGame::class, 'lottery_game_id');
    }
}
