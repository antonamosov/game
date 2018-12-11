<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnswerCheckRequest;
use App\Models\Game;
use App\Services\AnswerService;

class AnswerController extends BaseApiController
{
    public function check(Game $game, AnswerCheckRequest $request, AnswerService $answer)
    {
        $rightAnswer = $answer->answer($game, $request->answer);

        return $this->respond([
            'success' => $rightAnswer
        ]);
    }
}
