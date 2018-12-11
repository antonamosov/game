<?php

namespace App\Listeners;

use App\Events\UserAnswered;
use App\Services\TrainingManageService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateTrainingToNextTurn
{
    /**
     * @var TrainingManageService $training
     */
    private $training;

    /**
     * Create the event listener.
     *
     * @param TrainingManageService $trainingService
     * @return void
     */
    public function __construct(TrainingManageService $trainingService)
    {
        $this->training = $trainingService;
    }

    /**
     * Handle the event.
     *
     * @param  UserAnswered  $event
     * @return void
     */
    public function handle(UserAnswered $event)
    {
        if ($event->game->isTraining()) {
            $this->training->changeState($event->game, $event->answerIsRight);
        }
    }
}
