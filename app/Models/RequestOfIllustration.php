<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class RequestOfIllustration extends Model
{
    protected $table = 'request_of_illustrations';
    protected $primaryKey = 'num';

    /**
     * 하나의 회원은 여러 일러스트 신청을 할 수 있다.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}

