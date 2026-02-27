<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\LotterySyncService;

class SyncMegaSena extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lottery:sync-mega';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Busca os resultados históricos da Mega-Sena via API';

    /**
     * Execute the console command.
     */
    public function handle(LotterySyncService $service): void
    {
        $this->info('Iniciando sincronização com a API...');
        
        $result = $service->syncMegaSena();

        if ($result['success']) 
            $this->info($result['message']);
        else 
            $this->error($result['message']);
            
        }
}
