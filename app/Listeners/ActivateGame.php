<?php

namespace App\Listeners;

use App\Events\NotificationAccepted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ActivateGame
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
     * @param  NotificationAccepted  $event
     * @return void
     */
    public function handle(NotificationAccepted $event)
    {
        $event->notification->Game->activate();
    }
}
