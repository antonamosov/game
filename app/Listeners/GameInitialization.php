<?php

namespace App\Listeners;

use App\Events\GameActivated;
use App\Services\GameInitializationService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GameInitialization
{
    /**
     * @var GameInitializationService $gameInit
     */
    private $gameInit;

    /**
     * Create the event listener.
     *
     * @param GameInitializationService $gameInit
     * @return void
     */
    public function __construct(GameInitializationService $gameInit)
    {
        $this->gameInit = $gameInit;
    }

    /**
     * Handle the event.
     *
     * @param  GameActivated  $event
     * @return void
     */
    public function handle(GameActivated $event)
    {
        $this->gameInit->init($event->game);
    }
}
