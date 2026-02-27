<?php

namespace Tests\Feature;

use App\Models\LotteryGame;
use App\Models\LotteryResult;
use App\Services\LotterySyncService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class LotterySyncTest extends TestCase
{
    use RefreshDatabase;

    public function test_sync_mega_sena_saves_data_correctly(): void
    {
        // 1. Preparar o ambiente
        $game = LotteryGame::create([
            'name' => 'Mega-Sena',
            'slug' => 'mega-sena',
            'min_number' => 1,
            'max_number' => 60,
            'numbers_drawn' => 6,
        ]);

        // 2. Simular a resposta da API (Mock)
        Http::fake([
            'loteriascaixa-api.herokuapp.com/*' => Http::response([
                [
                    'concurso' => 2977,
                    'data' => '26/02/2026',
                    'dezenas' => ['52', '08', '38', '19', '27', '32'], // Fora de ordem
                    'local' => 'São Paulo, SP',
                    'acumulou' => true,
                ]
            ], 200),
        ]);

        // 3. Executar o serviço
        $service = app(LotterySyncService::class);
        $service->syncMegaSena();

        // 4. Asserções (Verificações)
        $this->assertDatabaseHas('lottery_results', [
            'contest_number' => 2977,
            'n1' => 8,  // Deve estar ordenado
            'n6' => 52, // Deve estar ordenado
        ]);

        $this->assertEquals(1, LotteryResult::count());
    }
}