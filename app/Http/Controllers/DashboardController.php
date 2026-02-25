<?php

namespace App\Http\Controllers;

use App\Models\LotteryGame;
use App\Models\LotteryPrediction;
use App\Services\LotteryAnalysisService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private readonly LotteryAnalysisService $analysisService
    ) {}

    public function index(Request $request): View
    {
        $games = LotteryGame::where('active', true)->get();
        $recentPredictions = LotteryPrediction::where('user_id', $request->user()->id)
            ->with('game')
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard', compact('games', 'recentPredictions'));
    }
}
