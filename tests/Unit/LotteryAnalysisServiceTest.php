<?php

namespace Tests\Unit;

use App\Models\LotteryGame;
use App\Models\LotteryResult;
use App\Services\CombinatoricsService;
use App\Services\LotteryAnalysisService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LotteryAnalysisServiceTest extends TestCase
{
    use RefreshDatabase;

    private LotteryAnalysisService $service;
    private LotteryGame $game;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new LotteryAnalysisService(new CombinatoricsService);

        $this->game = LotteryGame::create([
            'name' => 'Mega-Sena',
            'slug' => 'mega-sena',
            'min_number' => 1,
            'max_number' => 60,
            'numbers_drawn' => 6,
            'active' => true,
        ]);
    }

    public function test_get_number_frequency_returns_all_numbers(): void
    {
        LotteryResult::create([
            'lottery_game_id' => $this->game->id,
            'contest_number' => 1,
            'draw_date' => now()->subDays(7),
            'n1' => 1, 'n2' => 2, 'n3' => 3, 'n4' => 4, 'n5' => 5, 'n6' => 6,
        ]);

        $frequency = $this->service->getNumberFrequency($this->game);

        $this->assertCount(60, $frequency);
        $this->assertArrayHasKey('number', $frequency[0]);
        $this->assertArrayHasKey('frequency', $frequency[0]);
        $this->assertArrayHasKey('percentage', $frequency[0]);
    }

    public function test_get_most_frequent_numbers_returns_correct_count(): void
    {
        LotteryResult::create([
            'lottery_game_id' => $this->game->id,
            'contest_number' => 1,
            'draw_date' => now()->subDays(7),
            'n1' => 1, 'n2' => 2, 'n3' => 3, 'n4' => 4, 'n5' => 5, 'n6' => 6,
        ]);

        $hotNumbers = $this->service->getMostFrequentNumbers($this->game, 6);

        $this->assertCount(6, $hotNumbers);
    }

    public function test_get_game_statistics_returns_expected_keys(): void
    {
        $stats = $this->service->getGameStatistics($this->game);

        $this->assertArrayHasKey('total_draws', $stats);
        $this->assertArrayHasKey('total_combinations', $stats);
        $this->assertArrayHasKey('probability_per_draw', $stats);
        // C(60, 6) = 50.063.860
        $this->assertEquals(50063860, $stats['total_combinations']);
    }

    public function test_generate_frequency_prediction_returns_correct_count(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $numbers = array_rand(array_flip(range(1, 60)), 6);
            sort($numbers); 

            LotteryResult::create([
                'lottery_game_id' => $this->game->id,
                'contest_number' => $i,
                'draw_date' => now()->subDays($i * 7),
                'n1' => $numbers[0],
                'n2' => $numbers[1],
                'n3' => $numbers[2],
                'n4' => $numbers[3],
                'n5' => $numbers[4],
                'n6' => $numbers[5],
                'extra_data' => [],
            ]);
        }

        $prediction = $this->service->generateFrequencyPrediction($this->game);

        $this->assertArrayHasKey('numbers', $prediction);
        $this->assertArrayHasKey('strategy', $prediction);
        $this->assertArrayHasKey('confidence_score', $prediction);
        $this->assertCount($this->game->numbers_drawn, $prediction['numbers']);
        $this->assertEquals('frequency', $prediction['strategy']);
    }
}
