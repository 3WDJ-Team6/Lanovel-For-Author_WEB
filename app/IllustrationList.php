<?php

namespace App;

use App\User;
use App\CommentOfIllustration;
use App\Grade;
use App\BuyerOfIllustration;
use App\CategoryIllustration;
use Illuminate\Database\Eloquent\Model;

class IllustrationList extends Model
{
    protected $table = 'illustration_lists';
    protected $primaryKey = 'num';

    /**
     * 하나의 회원은 여러 일러스트를 가질 수 있다.
     */
    public function user(){
        return $this->belongsTo('App\User');
    }

    /**
     * 하나의 일러스트는 여러 댓글을 가질 수 있다.
     */
    public function comment_of_illustrations(){
        return $this->hasMany('App\CommentOfIllustration');
    }

    /**
     * 하나의 일러스트는 여러 평점을 가질 수 있다.
     */
    public function grades(){
        return $this->hasMany('App\Grade');
    }

    /**
     * 하나의 일러스트는 여러 일러스트 구매 테이블을 가질 수 있다.
     */
    public function buyer_of_illustrations(){
        return $this->hasMany('App\BuyerOfIllustration');
    }

    /**
     * 하나의 일러스트는 여러 일러스트 카테고리를 가질 수 있다.
     */
    public function category_illustrations(){
        return $this->hasMany('App\CategoryIllustration');
    }
}