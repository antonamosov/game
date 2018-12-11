<?php

namespace App\Events;

use App\Models\Game;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class GameActivated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Game $game
     */
    public $game;

    /**
     * Create a new event instance.
     *
     * @param Game $game
     * @return void
     */
    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
