<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Game;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->integer('user_turn_id')->nullable();
            $table->integer('user_id');
            $table->integer('opponent_id')->nullable();
            $table->enum('status', [
                Game::STATUS_ACTIVE,
                Game::STATUS_FINISHED,
                Game::STATUS_WAITING
            ])->default(Game::STATUS_WAITING);
            $table->enum('type', [
                Game::TYPE_TRAINING,
                Game::TYPE_GAME
            ])->default(Game::TYPE_GAME);
            $table->integer('question_id')->nullable();
            $table->integer('round_number')->nullable();
            $table->integer('turn_number')->nullable();
            $table->boolean('user_answered')->nullable();
            $table->boolean('opponent_answered')->nullable();
            $table->integer('user_glasses')->default(0);
            $table->integer('opponent_glasses')->default(0);
            $table->integer('earned_coins')->nullable();
            $table->integer('winner_id')->nullable();
            $table->integer('loser_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
