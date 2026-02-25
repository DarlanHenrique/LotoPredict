<?php

namespace Tests\Unit;

use App\Services\CombinatoricsService;
use PHPUnit\Framework\TestCase;

class CombinatoricsServiceTest extends TestCase
{
    private CombinatoricsService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CombinatoricsService;
    }

    public function test_combinations_returns_correct_value(): void
    {
        // C(6, 6) from 60 numbers = 50,063,860 (Mega-Sena)
        $this->assertEquals(50063860, $this->service->combinations(60, 6));

        // C(5, 5) basic cases
        $this->assertEquals(10, $this->service->combinations(5, 2));
        $this->assertEquals(1, $this->service->combinations(5, 0));
        $this->assertEquals(1, $this->service->combinations(5, 5));
        $this->assertEquals(5, $this->service->combinations(5, 1));
    }

    public function test_combinations_returns_zero_for_invalid_inputs(): void
    {
        $this->assertEquals(0, $this->service->combinations(3, 5));
        $this->assertEquals(0, $this->service->combinations(5, -1));
    }

    public function test_generate_combinations_returns_correct_count(): void
    {
        $combinations = $this->service->generateCombinations([1, 2, 3, 4, 5], 2);

        $this->assertCount(10, $combinations);
    }

    public function test_generate_combinations_contains_unique_combinations(): void
    {
        $combinations = $this->service->generateCombinations([1, 2, 3], 2);

        $expected = [[1, 2], [1, 3], [2, 3]];
        $this->assertEquals($expected, $combinations);
    }

    public function test_combination_probability_is_inverse_of_total_combinations(): void
    {
        $probability = $this->service->combinationProbability(60, 6);
        $expected = 1.0 / $this->service->combinations(60, 6);

        $this->assertEqualsWithDelta($expected, $probability, 1e-15);
    }

    public function test_combination_probability_returns_zero_for_invalid(): void
    {
        $this->assertEquals(0.0, $this->service->combinationProbability(5, 10));
    }

    public function test_odds_by_match_count_returns_valid_probability(): void
    {
        $odds = $this->service->oddsByMatchCount(60, 6, 6);

        $this->assertGreaterThan(0.0, $odds);
        $this->assertLessThanOrEqual(1.0, $odds);
    }

    public function test_odds_by_match_count_returns_zero_for_invalid_matches(): void
    {
        $this->assertEquals(0.0, $this->service->oddsByMatchCount(60, 6, 7));
        $this->assertEquals(0.0, $this->service->oddsByMatchCount(60, 6, -1));
    }
}
