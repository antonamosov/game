<?php

namespace App\Listeners;

use App\Events\GameCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateNotification
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
     * @param  GameCreated  $event
     * @return void
     */
    public function handle(GameCreated $event)
    {
        if ($event->game->isDoubles()) {
            $event->game->notifications()->create([
                'user_id' => $event->game->Opponent->id,
            ]);
        }
    }
}
