<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class InviteEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $toid;
    public $fromid;
    public $mtitle;
    public $content;
    public $time;
    public $num;


    /**
     * Create a new event instance.
     *
     * @param  \App\title  $title
     * @return void
     */
    public function __construct($user1 ,$user2, $title,$content)
    {
        $this->mtitle = $title;
        $this->toid = $user1;
        $this->fromid = $user2;
        $this->content = $content;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('invite');
    }
}
