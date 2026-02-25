<?php

namespace Database\Seeders;

use App\Models\LotteryGame;
use Illuminate\Database\Seeder;

class LotteryGameSeeder extends Seeder
{
    public function run(): void
    {
        $games = [
            [
                'name' => 'Mega-Sena',
                'slug' => 'mega-sena',
                'min_number' => 1,
                'max_number' => 60,
                'numbers_drawn' => 6,
                'active' => true,
            ],
            [
                'name' => 'Lotofácil',
                'slug' => 'lotofacil',
                'min_number' => 1,
                'max_number' => 25,
                'numbers_drawn' => 15,
                'active' => true,
            ],
            [
                'name' => 'Quina',
                'slug' => 'quina',
                'min_number' => 1,
                'max_number' => 80,
                'numbers_drawn' => 5,
                'active' => true,
            ],
            [
                'name' => 'Lotomania',
                'slug' => 'lotomania',
                'min_number' => 0,
                'max_number' => 99,
                'numbers_drawn' => 20,
                'active' => true,
            ],
            [
                'name' => 'Timemania',
                'slug' => 'timemania',
                'min_number' => 1,
                'max_number' => 80,
                'numbers_drawn' => 7,
                'active' => true,
            ],
        ];

        foreach ($games as $game) {
            LotteryGame::firstOrCreate(['slug' => $game['slug']], $game);
        }
    }
}
