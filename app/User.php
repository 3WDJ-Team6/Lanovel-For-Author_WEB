<?php

namespace App\Models;

use Hash;
use App\Models\Work;
use App\Models\Viewer;
use App\Models\Message;
use App\Models\Following;
use App\Models\RequestOfIllustration;
use App\Models\IllustrationList;
use App\Models\Review;
use App\Models\CommentOfWork;
use App\Models\CommentOfIllustration;
use App\Models\WorkList;
use App\Models\PushAlarm;

use Tymon\JWTAuth\Contracts\JWTSubject; # Update User model

use Illuminate\Notifications\Notifiable; # 비밀번호 변경 메일을 위해 필요한 trait
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable; # 라라벨 인증

# Trait 사용
use App\Traits\ModelScopes;

class User extends Authenticatable
{
    use ModelScopes;
    use Notifiable;

    protected $fillable = [
        'email', 'nickname', 'password', 'profile_photo', 'introduction_message', 'roles'
    ];

    # 쿼리 결과에서 제외할 칼럼들 (사용 안하는 칼럼)
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getAuthPassword()
    {
        // bcrypt 비교를 하지 않기 위해 강제로 해시를 생성한다.
        return Hash::make($this->password);
    }

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
}
