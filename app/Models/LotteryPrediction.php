<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LotteryPrediction extends Model
{
    protected $fillable = [
        'user_id',
        'lottery_game_id',
        'predicted_numbers',
        'strategy',
        'confidence_score',
        'metadata',
    ];

    protected $casts = [
        'predicted_numbers' => 'array',
        'metadata' => 'array',
        'confidence_score' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(LotteryGame::class, 'lottery_game_id');
    }
}
