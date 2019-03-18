<?php

namespace App;

use App\Work;
use App\Viewer;
use App\Message;
use App\Following;
use App\RequestOfIllustration;
use App\IllustrationList;
use App\Review;
use App\CommentOfWork;
use App\CommentOfIllustration;
use App\WorkList;
use App\PushAlarm;
use App\SubscribeOrInterest;
use App\ChatRoom;
use App\RecommendOfWork;
use App\BuyerOfIllustration;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 하나의 회원은 여러 작품을 가질 수 있다.
     * 하나의 작품은 여러 회원을 가질 수 있다.
     */
    public function works()
    {
        return $this->belongsToMany('App\Work');
    }

    /**
     * 하나의 회원은 하나의 뷰어 설정을 갖는다.
     */
    public function viewer()
    {
        return $this->hasOne('App\View');
    }

    /**
     * 하나의 회원은 여러 메시지를 가질 수 있다.
     */
    public function messages()
    {
        return $this->hasMany('App\Message');
    }

    /**
     * 하나의 회원은 여러 팔로잉 회원을 가질 수 있다.
     */
    public function followings()
    {
        return $this->hasMany('App\Following');
    }

    /**
     * 하나의 회원은 여러 일러스트 신청을 할 수 있다.
     */
    public function request_of_illustrations()
    {
        return $this->hasMany('App\RequestOfIllustration');
    }

    /**
     * 하나의 회원은 여러 일러스트를 가질 수 있다.
     */
    public function illustration_lists()
    {
        return $this->hasMany('App\IllustrationList');
    }

    /**
     * 하나의 회원은 여러 리뷰를 쓸 수 있다.
     */
    public function reviews()
    {
        return $this->hasMany('App\Review');
    }

    /**
     * 하나의 회원은 작품에 여러 댓글을 쓸 수 있다.
     */
    public function comment_of_works()
    {
        return $this->hasMany('App\CommentOfWork');
    }

    /**
     * 하나의 회원은 일러스트에 여러 댓글을 쓸 수 있다.
     */
    public function comment_of_illustrations()
    {
        return $this->hasMany('App\CommentOfIllustration');
    }

    /**
     * 하나의 회원은 여러 작품 리스트에 참여할 수 있다.
     * 하나의 작품 리스트는 여러 회원을 포함할 수 있다.
     * 회원 : 작품 리스트 = 일 : 다
     */
    public function work_lists()
    {
        return $this->belongsTo('App\WorkList');
    }

    /**
     * 하나의 회원은 여러 푸쉬알람을 가질 수 있다.
     */
    public function push_alarms()
    {
        return $this->hasMany('App\PushAlarm');
    }
    /**
     * 하나의 회원은 여러 구독 및 관심 테이블을 가질 수 있다.
     */
    public function subscribe_or_interests(){
        return  $this->hasMany('App\SubscribeOrInterest');
    }

    /**
     * 하나의 회원은 여러 채팅방을 가질 수 있다.
     */
    public function chat_room(){
        return  $this->hasMany('App\ChatRoom');
    }
    
    /**
     * 하나의 회원은 여러 추천 테이블을 갖는다.
     */
    public function recommend_of_works(){
        return  $this->hasMany('App\RecommendOfWork');
    }

    /**
     * 하나의 회원은 여러 일러스트 구매 테이블을 갖는다.
     */
    public function buyer_of_illustrations(){
        return  $this->hasMany('App\BuyerOfIllustration');
    }
}

 