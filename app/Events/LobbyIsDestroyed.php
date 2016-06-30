<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LobbyIsDestroyed extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $user;
    public $lobbyId;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(\App\User $user, $lobbyId)
    {
        $this->user = $user;
        $this->lobbyId = $lobbyId;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['lobby-channel'];
    }
}
