<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionGetRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Game;
use App\Services\QuestionService;

class QuestionController extends BaseApiController
{
    public function get(Game $game, QuestionGetRequest $request, QuestionService $question)
    {
        //$question = $question->get($game);

        return $this->respond([
            'data' => new QuestionResource($game->Question)
        ]);
    }
}
