<?php

namespace App\Services;

use App\Models\LotteryGame;
use App\Models\LotteryResult;
use Illuminate\Support\Collection;

/**
 * Service for analyzing historical lottery data and generating frequency statistics.
 */
class LotteryAnalysisService
{
    public function __construct(
        private readonly CombinatoricsService $combinatorics
    ) {}

    /**
     * Get number frequency analysis for a given lottery game.
     *
     * @return array<int, array{number: int, frequency: int, percentage: float}>
     */
    public function getNumberFrequency(LotteryGame $game, int $lastDraws = 100): array
    {
        $results = LotteryResult::where('lottery_game_id', $game->id)
            ->orderByDesc('draw_date')
            ->limit($lastDraws)
            ->get();

        $frequency = [];

        foreach ($results as $result) {
            // Agrupamos as novas colunas em um array para análise
            $drawn = [$result->n1, $result->n2, $result->n3, $result->n4, $result->n5, $result->n6];
            
            foreach ($drawn as $number) {
                if ($number > 0) {
                    $frequency[$number] = ($frequency[$number] ?? 0) + 1;
                }
            }
        }

        $totalDraws = $results->count();
        $analysis = [];

        for ($i = $game->min_number; $i <= $game->max_number; $i++) {
            $freq = $frequency[$i] ?? 0;
            $analysis[] = [
                'number' => $i,
                'frequency' => $freq,
                'percentage' => $totalDraws > 0 ? round(($freq / $totalDraws) * 100, 2) : 0.0,
            ];
        }

        usort($analysis, fn ($a, $b) => $b['frequency'] <=> $a['frequency']);

        return $analysis;
    }

    /**
     * Get the most frequent numbers for a given lottery game.
     *
     * @return array<int>
     */
    public function getMostFrequentNumbers(LotteryGame $game, int $topCount, int $lastDraws = 100): array
    {
        $analysis = $this->getNumberFrequency($game, $lastDraws);

        return array_column(array_slice($analysis, 0, $topCount), 'number');
    }

    /**
     * Get the least frequent ("cold") numbers for a given lottery game.
     *
     * @return array<int>
     */
    public function getLeastFrequentNumbers(LotteryGame $game, int $topCount, int $lastDraws = 100): array
    {
        $analysis = $this->getNumberFrequency($game, $lastDraws);

        $sorted = array_reverse($analysis);

        return array_column(array_slice($sorted, 0, $topCount), 'number');
    }

    /**
     * Generate a prediction based on frequency analysis.
     *
     * @return array{numbers: array<int>, strategy: string, confidence_score: float}
     */
    public function generateFrequencyPrediction(LotteryGame $game, int $lastDraws = 100): array
    {
        $hotNumbers = $this->getMostFrequentNumbers($game, (int) round($game->numbers_drawn * 0.6), $lastDraws);
        $coldNumbers = $this->getLeastFrequentNumbers($game, (int) round($game->numbers_drawn * 0.4), $lastDraws);

        $numbers = array_unique(array_merge(
            array_slice($hotNumbers, 0, (int) ceil($game->numbers_drawn * 0.6)),
            array_slice($coldNumbers, 0, (int) ceil($game->numbers_drawn * 0.4)),
        ));

        while (count($numbers) < $game->numbers_drawn) {
            $random = rand($game->min_number, $game->max_number);
            if (! in_array($random, $numbers)) {
                $numbers[] = $random;
            }
        }

        sort($numbers);

        $probability = $this->combinatorics->combinationProbability(
            $game->max_number - $game->min_number + 1,
            $game->numbers_drawn
        );

        $confidenceScore = min(99.99, round($probability * 1000000 * 100, 2));

        return [
            'numbers' => array_slice($numbers, 0, $game->numbers_drawn),
            'strategy' => 'frequency',
            'confidence_score' => $confidenceScore,
        ];
    }

    /**
     * Get statistics summary for a lottery game.
     *
     * @return array{total_draws: int, total_combinations: int, probability_per_draw: float}
     */
    public function getGameStatistics(LotteryGame $game): array
    {
        $totalDraws = LotteryResult::where('lottery_game_id', $game->id)->count();
        $totalNumbers = $game->max_number - $game->min_number + 1;
        $totalCombinations = $this->combinatorics->combinations($totalNumbers, $game->numbers_drawn);
        $probability = $this->combinatorics->combinationProbability($totalNumbers, $game->numbers_drawn);

        return [
            'total_draws' => $totalDraws,
            'total_combinations' => $totalCombinations,
            'probability_per_draw' => $probability,
        ];
    }
}
