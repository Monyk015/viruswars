<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LobbyIsCreated extends Event implements ShouldBroadcast
{
    use SerializesModels;
    public $user;
    public $lobby;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(\App\User $user,  \App\Lobby $lobby)
    {
        $this->user = $user;
        $this->lobby = $lobby;
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
