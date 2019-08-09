<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\User;

class ChatEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $user;

    public function __construct($messages = null, $user = null)
    {
        $this->message = $messages;
        $this->user = $user->nickname;
        $this->dontBroadcastToCurrentUser();
    }

    public function broadcastOn()
    {
        return new Channel('chat');
    }

    public function broadcastWith()
    {
        return [
            "status" => "success",
            "nickName" => $this->user,
            'message' => $this->message
        ];
    }
}
