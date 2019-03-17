<?php

namespace App;

use App\User;
use App\Review;
use App\CommentOfWork;
use App\WorkList;
use App\PushAlarm;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $table = 'works';
    protected $primaryKey = 'num';

    /**
     * 하나의 작품은 여러 회원을 가질 수 있다.
     * 하나의 회원은 여러 작품을 가질 수 있다.
     * 작품 : 회원 = 다 : 다
     */
    public function users(){
        return $this->belongsToMany('App\User');
    }

    /**
     * 하나의 작품은 여러 리뷰를 가질 수 있다.
     */
    public function reviews(){
        return $this->hasMany('App\Review');
    }

    /**
     * 하나의 작품은 여러 댓글을 가질 수 있다.
     */
    public function comment_of_works(){
        return $this->hasMany('App\CommentOfWork');
    }

    /**
     * 하나의 작품은 여러 작품 참여 리스트를 가질 수 있다.
     */
    public function work_lists(){
        return $this->hasMany('App\WorkList');
    }

    
    /**
     * 하나의 작품은 여러 푸쉬알람을 가질 수 있다.
     */
    public function push_alarms(){
        return $this->hasMany('App\PushAlarm');
    }
}
