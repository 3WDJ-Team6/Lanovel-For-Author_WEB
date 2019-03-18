<?php

namespace App;

use App\User;
use App\Review;
use App\CommentOfWork;
use App\WorkList;
use App\PushAlarm;
use App\SubscribeOrInterest;
use App\ChatRoom;
use App\RecommendOfWork;
use App\Grade;
use App\CategoryWork;
use App\Contract;
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

    /**
     * 하나의 작품은 여러 구독 및 관심 테이블을 가질 수 있다.
     */
    public function subscribe_or_interests(){
        return $this->hasMany('App\SubscribeOrInterest');
    }

    /**
     * 하나의 작품은 하나의 채팅방을 갖는다.
     */
    public function chat_room(){
        return $this->hasOne('App\ChatRoom');
    }

    /**
     * 하나의 작품은 여러 추천 테이블을 갖는다.
     */
    public function recommend_of_works(){
        return $this->hasMany('App\RecommendOfWork');
    }

     /**
     * 하나의 작품은 여러 평점을 가질 수 있다.
     */
    public function grades(){
        return $this->hasMany('App\Grade');
    }

    /**
     * 하나의 작품은 여러 카테고리를 가질 수 있다.
     */
    public function category_works(){
        return $this->hasMany('App\CategoryWork');
    }

    /**
     * 하나의 작품은 하나의 계약서를 가질 수 있다.
     */
    public function contract(){
        return $this->hasOne('App\Contract');
    }
}
