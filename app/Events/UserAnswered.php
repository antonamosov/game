<?php

namespace App\Events;

use App\Models\Game;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserAnswered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Game $game;
     */
    public $game;

    public $answerIsRight;
    /**
     * Create a new event instance.
     * @param Game $game
     * @param $answerIsRight
     * @return void
     */
    public function __construct(Game $game, $answerIsRight)
    {
        $this->game = $game;
        $this->answerIsRight = $answerIsRight;
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
