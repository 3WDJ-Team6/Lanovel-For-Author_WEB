<?php

namespace App;

use App\User;
use App\Work;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';
    protected $primaryKey = 'num';

    /**
     * 하나의 작품은 여러 리뷰를 가질 수 있다.
     */
    public function work(){
        return $this->belongsTo('App\Work');
    }

    /**
     * 하나의 사용자는 여러 리뷰를 가질 수 있다.
     */
    public function user(){
        return $this->belongsTo('App\User');
    }
}
