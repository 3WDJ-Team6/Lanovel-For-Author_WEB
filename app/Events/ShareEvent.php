<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Redis;
use App\Models\ContentOfWork;
use DB;

class ShareEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $nickname;
    public $num;
    public $content;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($nickname = null, $num = null, $content = null)
    {
        $this->nickname = $nickname;
        $this->num = $num;
        $this->content = $content;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        # redis 채널 이름
        return new Channel('share-event');
    }

    # 이벤트가 호출될 때 호출되며, 소켓 서버로 반환되는 데이터
    public function broadcastWith()
    {
        return [
            "status" => "success",
            "nickname" => $this->nickname,
            "num" => $this->num,
            "content" => $this->content,
            // "content" => DB::table('content_of_works')->where('num', 245)->get(),
            // "ct" => $this->content
        ];
    }
}
