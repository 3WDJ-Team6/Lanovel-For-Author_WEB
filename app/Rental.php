<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $table='rentals';

    /**
     * 하나의 회원은 여러 대여 테이블을 가질 수 있다.
     */
    public function user(){
        return $this->belongsTo('App\User');
    }

    /**
     * 하나의 작품은 여러 대여 테이블을 가질 수 있다.
     */
    public function work(){
        return $this->belongsTo('App\Work');
    }
}
