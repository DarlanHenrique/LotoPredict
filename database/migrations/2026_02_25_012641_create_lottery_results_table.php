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
            $table->index();
            $table->foreignId('lottery_game_id')->constrained()->cascadeOnDelete();
            $table->integer('contest_number');
            $table->date('draw_date');
            $table->unsignedTinyInteger('n1');
            $table->unsignedTinyInteger('n2');
            $table->unsignedTinyInteger('n3');
            $table->unsignedTinyInteger('n4');
            $table->unsignedTinyInteger('n5');
            $table->unsignedTinyInteger('n6');
            $table->json('extra_data')->nullable();
            $table->timestamps();

            $table->unique(['lottery_game_id', 'contest_number']);
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
