<?php

namespace App\Models;

use App\Models\User;
use App\Models\Work;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    protected $table = 'chat_rooms';
    // protected $primaryKey = 'num';

    /**
     * 하나의 회원은 여러 채팅방을 가질 수 있다.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * 하나의 작품은 하나의 채팅방을 가진다.
     */
    public function work()
    {
        return $this->belongsTo('App\Models\Work');
    }
}
