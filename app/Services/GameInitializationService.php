<?php


namespace App\Services;

use App\Models\Game;
use App\Models\Round;

class GameInitializationService extends GameService
{
    public function init(Game $game)
    {
        $this->setGame($game);
        $this->setRandomQuestion();
        $this->setRandomUserTurn();
        $this->createRounds();
        $this->setStartRound();
        $this->setStartTurn();

        $this->saveGame();
    }


    private function setRandomUserTurn()
    {
        $userTurnId = $this->getRandomUserTurnId();

        $this->game->fill([
            'user_turn_id' => $userTurnId
        ]);
    }

    private function getRandomUserTurnId()
    {
        return $this->getRandomIndex([
            $this->game->user_id,
            $this->game->opponent_id
        ]);
    }

    private function createRounds()
    {
        foreach (range(1, self::MAX_ROUNDS) as $roundNumber) {
            $this->createRound($roundNumber);
        }
    }

    private function createRound($number)
    {
        $round = $this->game->Rounds()->create([
            'number' => $number
        ]);

        $this->createTurns($round);
    }

    private function createTurns($round)
    {
        foreach (range(1, self::MAX_QUESTIONS_IN_ROUND) as $turnNumber) {
            $this->createTurn($round, $turnNumber);
        }
    }

    private function createTurn(Round $round, $number)
    {
        $round->Turns()->create([
            'number' => $number,
            'user_id' => $this->game->user_id
        ]);

        $round->Turns()->create([
            'number' => $number,
            'user_id' => $this->game->opponent_id
        ]);
    }

    private function setStartRound()
    {
        $this->setCurrentRoundNumber(1);
    }

    private function setStartTurn()
    {
        $this->setCurrentTurnNumber(1);
    }
}