<?php


namespace App\Services;

use App\Models\Game;

class QuestionService
{
    /**
     * @var Game $game
     */
    private $game;

    public function get(Game $game)
    {
        $this->setGame($game);
        $question = $this->getCurrentQuestion();

        return $question;
    }

    private function setGame($game)
    {
        $this->game = $game;
    }

    private function getCurrentQuestion()
    {
        return $this->game->Question;
    }
}