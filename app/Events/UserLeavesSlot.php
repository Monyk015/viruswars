<?php

namespace App\Events;

use App\User;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserLeavesSlot extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $user;
    public $lobbyId;
    public $slotId;

    public function __construct(User $user, $lobbyId, $slotId)
    {
        $this->user = $user;
        $this->lobbyId = $lobbyId;
        $this->slotId = $slotId;
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
