<?php


namespace App\Services;

use App\Events\UserAnswered;
use App\Models\Game;

class AnswerService extends GameService
{
    private $clientAnswer;

    public function answer(Game $game, $clientAnswer)
    {
        $this->setGame($game);
        $this->setAnswer($clientAnswer);

        $answerIsRight = $this->check();

        $this->saveAnswer($answerIsRight);

        return $answerIsRight;
    }

    private function check()
    {

        $answer = $this->getRightAnswer();
        $answerIsRight = $this->checkAnswer($answer);

        return $answerIsRight;
    }

    private function setAnswer($answer)
    {
        $this->clientAnswer = $answer;
    }

    private function GetRightAnswer()
    {
        return $this->game->Question->Answers()->right()->first()->title;
    }

    private function checkAnswer($answer)
    {
        return trim(strtolower($this->clientAnswer)) === strtolower($answer);
    }

    private function saveAnswer($answerIsRight)
    {
        event(new UserAnswered($this->game, $answerIsRight));
    }
}