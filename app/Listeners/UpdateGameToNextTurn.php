<?php

namespace App\Listeners;

use App\Events\UserAnswered;
use App\Services\GameManageService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateGameToNextTurn
{
    /**
     * @var GameManageService $gameService
     */
    protected $gameService;

    /**
     * Create the event listener.
     *
     * @param GameManageService $gameService
     * @return void
     */
    public function __construct(GameManageService $gameService)
    {
        $this->gameService = $gameService;
    }

    /**
     * Handle the event.
     *
     * @param  UserAnswered  $event
     * @return void
     */
    public function handle(UserAnswered $event)
    {
        if ($event->game->isDoubles()) {
            $this->gameService->changeState($event->game, $event->answerIsRight);
        }
    }
}
