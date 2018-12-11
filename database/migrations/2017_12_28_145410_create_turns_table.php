<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Turn;

class CreateTurnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turns', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('status', [
                Turn::STATUS_EMPTY,
                Turn::STATUS_RIGHT,
                Turn::STATUS_WRONG
            ])
                ->default(Turn::STATUS_EMPTY);
            $table->integer('number');
            $table->integer('round_id')->nullable();
            $table->integer('game_id')->nullable();
            $table->integer('user_id');
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
        Schema::dropIfExists('turns');
    }
}
