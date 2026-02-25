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
        'n1', 'n2', 'n3', 'n4', 'n5', 'n6',
        'extra_data',
    ];

    protected $casts = [
        'extra_data' => 'array',
        'draw_date' => 'date',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(LotteryGame::class, 'lottery_game_id');
    }
}
