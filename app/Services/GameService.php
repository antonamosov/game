<?php


namespace App\Services;

use App\Models\Game;

class GameService
{
    /**
     * @var Game $game
     */
    protected $game;

    const MAX_ROUNDS = 3;
    const MAX_QUESTIONS_IN_ROUND = 3;
    const MAX_TRAINING_QUESTIONS = 10;
    const MAX_ITERATIONS = 15;
    const REWARD = 1000;

    protected function setGame($game)
    {
        $this->game = $game;
    }

    protected function setNotRepeatedRandomQuestion()
    {
        $this->rememberCurrentQuestion();

        $questionId = $this->getNotRepeatedRandomQuestion();


        $this->game->fill([
            'question_id' => $questionId
        ]);
    }

    protected function setRandomQuestion()
    {
        $questionId = $this->getRandomQuestion();

        $this->game->fill([
            'question_id' => $questionId
        ]);
    }

    private function getNotRepeatedRandomQuestion()
    {
        $iterations = 0;
        do {
            $questionId = $this->getRandomQuestion();
            $iterations++;
        }
        while ($this->questionRepeated($questionId) && $iterations < self::MAX_ITERATIONS);

        return $questionId;
    }

    private function rememberCurrentQuestion()
    {
        $this->game->answeredQuestions()->create([
            'question_id' => $this->game->question_id
        ]);
    }

    private function questionRepeated($questionId)
    {
        $exists = $this->game->answeredQuestions()->where('question_id', $questionId)->first();

        return $exists ? true : false;
    }

    protected function getRandomIndex(array $arr)
    {
        $key = array_rand($arr);

        return $arr[$key];
    }

    protected function getRandomQuestion()
    {
        $packIdsArr = $this->game->Category->Questions()->pluck('id')->toArray();

        return $this->getRandomIndex($packIdsArr);
    }

    protected function setUserTurn($userId)
    {
        $this->game->fill([
            'user_turn_id' => $userId
        ]);
    }

    protected function setUserAnswered()
    {
        $this->game->fill([
            'user_answered' => true
        ]);
    }

    protected function setOpponentAnswered()
    {
        $this->game->fill([
            'opponent_answered' => true
        ]);
    }

    protected function clearUsersAreAnswered()
    {
        $this->game->fill([
            'user_answered' => false,
            'opponent_answered' => false
        ]);
    }

    protected function setCurrentRoundNumber($roundId)
    {
        $this->game->fill([
            'round_number' => $roundId
        ]);
    }

    protected function setCurrentTurnNumber($turnNumber)
    {
        $this->game->fill([
            'turn_number' => $turnNumber
        ]);
    }

    protected function incrementRoundNumber()
    {
        $this->game->fill([
            'round_number' => $this->game->round_number + 1
        ]);
    }

    protected function incrementTurnNumber()
    {
        $this->game->fill([
            'turn_number' => $this->game->turn_number + 1
        ]);
    }

    protected function incrementUserGlasses()
    {
        $this->game->fill([
            'user_glasses' => $this->game->user_glasses + 1
        ]);
    }

    protected function incrementOpponentGlasses()
    {
        $this->game->fill([
            'opponent_glasses' => $this->game->opponent_glasses + 1
        ]);
    }

    protected function setEarnedCoins()
    {
        $this->game->fill([
            'earned_coins' => self::REWARD
        ]);
    }

    protected function setWinnerUserId($id)
    {
        $this->game->fill([
            'winner_id' => $id
        ]);
    }

    protected function setLoserUserId($id)
    {
        $this->game->fill([
            'loser_id' => $id
        ]);
    }

    protected function saveGame()
    {
        $this->game->save();
    }
}