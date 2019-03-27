<?php

namespace App\Models;

use App\Models\User;
use App\Models\IllustrationList;
use Illuminate\Database\Eloquent\Model;

class BuyerOfIllustration extends Model
{
    protected $table = "buyer_of_illustrations";

    /**
     * 하나의 회원은 여러 개의 일러스트 구매 테이블을 가질 수 있다.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * 하나의 일러스트는 여러 개의 일러스트 구매 테이블을 가질 수 있다.
     */
    public function illustration_list()
    {
        return $this->belongsTo('App\Models\IllustrationList');
    }
}
