<?php

namespace App\Services;

/**
 * Service for combinatorics calculations used in lottery analysis.
 */
class CombinatoricsService
{
    /**
     * Calculate the number of combinations C(n, k) = n! / (k! * (n-k)!)
     */
    public function combinations(int $n, int $k): int
    {
        if ($k < 0 || $k > $n) {
            return 0;
        }

        if ($k === 0 || $k === $n) {
            return 1;
        }

        $k = min($k, $n - $k);
        $result = 1;

        for ($i = 0; $i < $k; $i++) {
            $result = intdiv($result * ($n - $i), $i + 1);
        }

        return $result;
    }

    /**
     * Generate all possible combinations of $k numbers from the given set.
     *
     * @param  array<int>  $numbers
     * @return array<array<int>>
     */
    public function generateCombinations(array $numbers, int $k): array
    {
        $result = [];
        $this->combineRecursive($numbers, $k, 0, [], $result);

        return $result;
    }

    /**
     * Calculate the probability of a given combination occurring.
     */
    public function combinationProbability(int $totalNumbers, int $drawCount): float
    {
        $totalCombinations = $this->combinations($totalNumbers, $drawCount);

        if ($totalCombinations === 0) {
            return 0.0;
        }

        return 1.0 / $totalCombinations;
    }

    /**
     * Calculate the odds of matching exactly $matches numbers in a draw.
     */
    public function oddsByMatchCount(int $totalNumbers, int $drawCount, int $matches): float
    {
        if ($matches > $drawCount || $matches < 0) {
            return 0.0;
        }

        $favorableOutcomes = $this->combinations($drawCount, $matches)
            * $this->combinations($totalNumbers - $drawCount, $drawCount - $matches);

        $totalOutcomes = $this->combinations($totalNumbers, $drawCount);

        if ($totalOutcomes === 0) {
            return 0.0;
        }

        return $favorableOutcomes / $totalOutcomes;
    }

    /**
     * Recursive helper for generating combinations.
     *
     * @param  array<int>  $numbers
     * @param  array<int>  $current
     * @param  array<array<int>>  $result
     */
    private function combineRecursive(array $numbers, int $k, int $start, array $current, array &$result): void
    {
        if (count($current) === $k) {
            $result[] = $current;

            return;
        }

        $remaining = $k - count($current);

        for ($i = $start; $i <= count($numbers) - $remaining; $i++) {
            $current[] = $numbers[$i];
            $this->combineRecursive($numbers, $k, $i + 1, $current, $result);
            array_pop($current);
        }
    }
}
