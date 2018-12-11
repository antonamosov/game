<?php

namespace App\Listeners;

use App\Events\GameCreated;
use App\Services\TrainingInitializationService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TrainingInitialization
{
    /**
     * @var TrainingInitializationService $trainingInit
     */
    private $trainingInit;

    /**
     * Create the event listener.
     *
     * @param TrainingInitializationService $trainingInit
     * @return void
     */
    public function __construct(TrainingInitializationService $trainingInit)
    {
        $this->trainingInit = $trainingInit;
    }

    /**
     * Handle the event.
     *
     * @param  GameCreated  $event
     * @return void
     */
    public function handle(GameCreated $event)
    {
        if ($event->game->isTraining()) {
            $this->trainingInit->init($event->game);
        }
    }
}
