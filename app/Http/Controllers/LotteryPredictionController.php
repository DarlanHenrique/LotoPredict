<?php

namespace App\Http\Controllers;

use App\Models\LotteryGame;
use App\Models\LotteryPrediction;
use App\Services\LotteryAnalysisService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LotteryPredictionController extends Controller
{
    public function __construct(
        private readonly LotteryAnalysisService $analysisService
    ) {}

    public function index(Request $request): View
    {
        $predictions = LotteryPrediction::where('user_id', $request->user()->id)
            ->with('game')
            ->latest()
            ->paginate(10);

        return view('predictions.index', compact('predictions'));
    }

    public function create(): View
    {
        $games = LotteryGame::where('active', true)->get();

        return view('predictions.create', compact('games'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'lottery_game_id' => ['required', 'exists:lottery_games,id'],
            'strategy' => ['required', 'in:frequency,random,balanced'],
        ]);

        $game = LotteryGame::findOrFail($validated['lottery_game_id']);
        $prediction = $this->analysisService->generateFrequencyPrediction($game);

        LotteryPrediction::create([
            'user_id' => $request->user()->id,
            'lottery_game_id' => $game->id,
            'predicted_numbers' => $prediction['numbers'],
            'strategy' => $validated['strategy'],
            'confidence_score' => $prediction['confidence_score'],
        ]);

        return redirect()->route('predictions.index')
            ->with('success', 'Prediction generated successfully!');
    }

    public function show(LotteryPrediction $prediction): View
    {
        $this->authorize('view', $prediction);

        $stats = $this->analysisService->getGameStatistics($prediction->game);

        return view('predictions.show', compact('prediction', 'stats'));
    }

    public function destroy(Request $request, LotteryPrediction $prediction): RedirectResponse
    {
        $this->authorize('delete', $prediction);

        $prediction->delete();

        return redirect()->route('predictions.index')
            ->with('success', 'Prediction deleted successfully!');
    }
}
