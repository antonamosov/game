<?php


namespace App\Services;

use App\Models\Game;
use App\Models\Round;
use App\Models\Turn;

class TrainingInitializationService extends GameService
{
    public function init(Game $game)
    {
        $this->setGame($game);
        $this->setRandomQuestion();
        $this->setCurrentTurnNumber(1);
        $this->saveGame();

        $this->createTurns();
    }

    private function createTurns()
    {
        foreach (range(1, self::MAX_TRAINING_QUESTIONS) as $turnNumber) {
            $this->createTurn($turnNumber);
        }
    }

    private function createTurn($number)
    {
        $this->game->Turns()->create([
            'number' => $number,
            'user_id' => $this->game->user_id,
        ]);
    }
}