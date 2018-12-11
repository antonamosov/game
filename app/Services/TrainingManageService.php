<?php


namespace App\Services;

use App\Models\Game;

class TrainingManageService extends GameService
{
    private $answerIsRight;

    public function changeState(Game $game, $answerIsRight)
    {
        $this->setGame($game);
        $this->setAnswerIsRight($answerIsRight);

        $this->saveAnswer();
        $this->changeUserTurn();
        $this->changeQuestion();

        $this->saveGame();

        if ($this->endOfQuestions()) {
            $this->finish();
        }


    }

    private function setAnswerIsRight($answerIsRight)
    {
        $this->answerIsRight = $answerIsRight;
    }

    private function saveAnswer()
    {
        $this->game->Turns()->user($this->game->user_id)->number($this->game->turn_number)->first()->setAnswer($this->answerIsRight);
    }

    private function changeUserTurn()
    {
        $this->setCurrentTurnNUmber($this->game->turn_number + 1);
    }

    private function changeQuestion()
    {
        $this->setRandomQuestion();
    }

    private function endOfQuestions()
    {
        return $this->game->turn_number > self::MAX_TRAINING_QUESTIONS ? true : false;
    }

    private function finish()
    {
        $this->game->finish();
    }
}