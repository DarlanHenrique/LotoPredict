<?php

namespace App\Services;

use App\Models\LotteryGame;
use App\Models\LotteryResult;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LotterySyncService
{
    public function __construct(
        private readonly LotteryAnalysisService $analysisService
    ) {}

    /**
     * Sync lottery results from an external API for a given lottery game.
     *
     * @return void
     */
    // TODO: Implementar lógica de sincronização com a API externa, incluindo tratamento de erros e atualização do banco de dados.
    protected $apiUrl = 'https://loteriascaixa-api.herokuapp.com/api/megasena';

    public function syncMegaSena() {
        $game = LotteryGame::where('slug', 'mega-sena')->first();

        if (!$game)
            return ['success' => false, 'message' => 'Jogo Mega-Sena não encontrado no banco.'];
        
        try {
            $response = Http::get($this->apiUrl);

            if ($response->failed())
                throw new \Exception('Falha ao conectar com a API de Loterias.');
            
            $results = $response->json();
            $syncCount = 0;

            foreach ($results as $data) {
                // 1. Extrair e ordenar as dezenas (Crucial para o seu índice composto!)
                $numbers = $data['dezenas']; 
                sort($numbers); // Garante n1 < n2 < n3...

                // 2. Usar updateOrCreate para evitar duplicidade (RF003)
                LotteryResult::updateOrCreate(
                    [
                        'lottery_game_id' => $game->id,
                        'contest_number' => $data['concurso'],
                    ],
                    [
                        'draw_date' => \Carbon\Carbon::createFromFormat('d/m/Y', $data['data']),
                        'n1' => (int) $numbers[0],
                        'n2' => (int) $numbers[1],
                        'n3' => (int) $numbers[2],
                        'n4' => (int) $numbers[3],
                        'n5' => (int) $numbers[4],
                        'n6' => (int) $numbers[5],
                        'extra_data' => [
                            'local' => $data['local'],
                            'premiacao' => $data['premiacoes'] ?? [],
                            'acumulou' => $data['acumulou']
                        ]
                    ]
                );
                $syncCount++;
            }

            return ['success' => true, 'message' => "Sincronização concluída! {$syncCount} concursos processados."];
        }
        catch (\Exception $e) {
            Log::error('Erro ao sincronizar resultados da Mega-Sena: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
