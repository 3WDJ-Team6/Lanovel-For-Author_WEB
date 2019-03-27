<?php

namespace App\Models;

use App\Models\User;
use App\Models\Work;
use Illuminate\Database\Eloquent\Model;

class PushAlarm extends Model
{
    protected $tabel = "push_alarms";

    /**
     * 하나의 회원은 여러 푸쉬알람을 가질 수 있다.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * 하나의 작품은 여러 푸쉬알람을 가질 수 있다.
     */
    public function work()
    {
        return $this->belongsTo('App\Models\Work');
    }
}
