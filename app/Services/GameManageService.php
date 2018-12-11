<?php


namespace App\Services;

use App\Models\Game;

class GameManageService extends GameService
{
    private $answerIsRight;

    public function changeState(Game $game, $answerIsRight)
    {
        $this->setGame($game);
        $this->setAnswerIsRight($answerIsRight);

        $this->saveAnswer();
        if ($this->endOfRound()) {
            $this->setUserIsAnswered();
        }
        $this->setGlasses();

        if (! $this->opponentAnswered()) {

            $this->changeUserTurn();
        }
        else {
            $this->changeUserTurn();
            $this->changeTurnNumber();
            $this->clearUsersAreAnswered();
            $this->changeRoundNumber();
            $this->changeQuestion();
        }

        $this->saveGame();

        if ($this->endOfRounds()) {
            $this->finish();
        }
    }

    private function setAnswerIsRight($answerIsRight)
    {
        $this->answerIsRight = $answerIsRight;
    }

    private function saveAnswer()
    {
        $this->game->getCurrentRound()->setTurn($this->answerIsRight, $this->game->user_turn_id, $this->game->turn_number);
    }

    private function setUserIsAnswered()
    {
        if ($this->isUserTurn()) {
            $this->setUserAnswered();
        }
        else {
            $this->setOpponentAnswered();
        }
    }

    private function setGlasses()
    {
        if ($this->isUserTurn() && $this->answerIsRight) {
            $this->incrementUserGlasses();
        }
        elseif (! $this->isUserTurn() && $this->answerIsRight) {
            $this->incrementOpponentGlasses();
        }
    }

    private function changeUserTurn()
    {
        if ($this->isUserTurn()) {
            $this->setUserTurn($this->game->opponent_id);
        }
        else {
            $this->setUserTurn($this->game->user_id);
        }
    }

    private function opponentAnswered()
    {
        return $this->game->allUsersAnswered();
    }

    private function changeRoundNumber()
    {
        if ((int) $this->game->turn_number > self::MAX_QUESTIONS_IN_ROUND) {
            $this->incrementRoundNumber();
            $this->setCurrentTurnNumber(1);
        }
    }

    private function changeTurnNumber()
    {
        $this->incrementTurnNumber();
    }

    private function changeQuestion()
    {
        $this->setRandomQuestion();
    }

    private function isUserTurn()
    {
        return $this->game->isUserTurn();
    }

    private function endOfRounds()
    {
        return (int) $this->game->round_number > self::MAX_ROUNDS;
    }

    private function finish()
    {
        $this->setEarnedCoins();
        $this->setResults();
        $this->saveGame();
        $this->game->finish();
    }

    private function setResults()
    {
        if ((int) $this->game->user_glasses > (int) $this->game->opponent_glasses) {
            $this->setWinnerUserId($this->game->user_id);
            $this->setLoserUserId($this->game->opponent_id);
        }
        elseif ((int) $this->game->user_glasses < (int) $this->game->opponent_glasses) {
            $this->setWinnerUserId($this->game->opponent_id);
            $this->setLoserUserId($this->game->user_id);
        }
    }
}