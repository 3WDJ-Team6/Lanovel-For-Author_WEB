<?php

namespace App;

use App\Work;
use App\IllustrationList;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table = 'grades';

    /**
     * 하나의 작품은 여러 개의 평점을 가질 수 있다.
     */
    public function work(){
        return $this->belongsTo('App\Work');
    }

    /**
     * 하나의 회원은 여러 개의 평점을 달 수 있다.
     */
    public function user(){
        return $this->belongsTo('App\User');
    }

    /**
     * 하나의 일러스트는 여러 개의 평점을 가질 수 있다.
     */
    public function illustration_list(){
        return $this->belongsTo('App\IllustrationList');
    }
}