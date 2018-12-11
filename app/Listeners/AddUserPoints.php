<?php

namespace App\Listeners;

use App\Events\GameFinished;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddUserPoints
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  GameFinished  $event
     * @return void
     */
    public function handle(GameFinished $event)
    {
        if (! $event->game->isDraw() && $event->game->isDoubles()) {
            $event->game->Winner->addPoints($event->game->getWinnerGlasses());
            $event->game->Loser->addPoints($event->game->getLoserGlasses());
        }
    }
}
