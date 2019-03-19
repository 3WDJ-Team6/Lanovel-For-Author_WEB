<?php

namespace App;

use App\User;
use App\Work;
use Illuminate\Database\Eloquent\Model;

class RecommendOfWork extends Model
{
    protected $table='recommend_of_works';

    /**
     * 하나의 회원은 여러 추천 테이블을 가질 수 있다.
     */
    public function user(){
        return $this->belongsTo('App\User');
    }

    /**
     * 하나의 작품은 여러 추천 테이블을 가질 수 있다.
     */
    public function work(){
        return $this->belongsTo('App\Work');
    }
}