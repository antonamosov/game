<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\GameCreated' => [
            'App\Listeners\CreateNotification',
            'App\Listeners\TrainingInitialization',
        ],
        'App\Events\NotificationAccepted' => [
            'App\Listeners\ActivateGame',
        ],
        'App\Events\NotificationRejected' => [
        ],
        'App\Events\NotificationDeleted' => [
            'App\Listeners\DeleteGame',
        ],
        'App\Events\GameActivated' => [
            'App\Listeners\GameInitialization',
        ],
        'App\Events\UserAnswered' => [
            'App\Listeners\UpdateGameToNextTurn',
            'App\Listeners\UpdateTrainingToNextTurn',
        ],
        'App\Events\GameFinished' => [
            'App\Listeners\AddUserCoins',
            'App\Listeners\AddUserPoints',
        ],
        'App\Events\UserPaid' => [
            'App\Listeners\UpdateUserAfterPaid',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
