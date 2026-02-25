<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lottery_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lottery_game_id')->constrained()->cascadeOnDelete();
            $table->integer('contest_number');
            $table->date('draw_date');
            
            // DEFINA AS COLUNAS PRIMEIRO
            $table->unsignedTinyInteger('n1');
            $table->unsignedTinyInteger('n2');
            $table->unsignedTinyInteger('n3');
            $table->unsignedTinyInteger('n4');
            $table->unsignedTinyInteger('n5');
            $table->unsignedTinyInteger('n6');

            $table->json('extra_data')->nullable();
            $table->timestamps();

            $table->unique(['lottery_game_id', 'contest_number']);
            
            // CRIE O ÍNDICE POR ÚLTIMO
            $table->index(['n1', 'n2', 'n3', 'n4', 'n5', 'n6'], 'idx_combinacao_resultado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lottery_results');
    }
};
