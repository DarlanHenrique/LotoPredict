<?php

namespace App\Policies;

use App\Models\LotteryPrediction;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LotteryPredictionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, LotteryPrediction $lotteryPrediction): bool
    {
        return $user->id === $lotteryPrediction->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, LotteryPrediction $lotteryPrediction): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, LotteryPrediction $lotteryPrediction): bool
    {
        return $user->id === $lotteryPrediction->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, LotteryPrediction $lotteryPrediction): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, LotteryPrediction $lotteryPrediction): bool
    {
        return false;
    }
}
