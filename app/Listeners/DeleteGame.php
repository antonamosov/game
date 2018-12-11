<?php

namespace App\Listeners;

use App\Events\NotificationRejected;

class DeleteGame
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
     * @param  NotificationRejected, NotificationDeleted  $event
     * @return void
     */
    public function handle($event)
    {
        if (! $event->notification->isAccepted() ) {
            $event->notification->Game->delete();
        }
    }
}
