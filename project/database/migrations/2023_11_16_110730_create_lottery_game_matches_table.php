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
        Schema::create('lottery_game_matches', function (Blueprint $table) {
            $table->id();
            //game_id
            $table->unsignedBigInteger('game_id');
            $table->foreign('game_id')->on('lottery_games')
            ->references('id');
            $table->date('start_date');
            $table->time('start_time');
            $table->boolean('is_finished')->default(false);
            //winner_id
            $table->unsignedBigInteger('winner_id')->nullable();
            $table->foreign('winner_id')->on('users')
                ->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lottery_game_matches');
    }
};
