<?php

namespace App\Models;

use App\Models\User;
use App\Models\Work;
use Illuminate\Database\Eloquent\Model;

class SubscribeOrInterest extends Model
{
    protected $table = 'subscribe_or_interests';

    /**
     * 하나의 회원은 여러 구독 및 관심 작품을 가질 수 있다.
     */
    public function user(){
        return $this->belongsTo('App\User');
    }

    /**
     * 하나의 작품은 여러 구독 및 관심 테이블을 가지 수 있다.
     */
    public function work(){
        return $this->belongsTo('App\Work');
    }
}