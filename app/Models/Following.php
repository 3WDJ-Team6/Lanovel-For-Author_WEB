<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Following extends Model
{
    protected $table = 'followings';

    /**
     * 하나의 회원은 여러 팔로잉 회원을 가질 수 있다.
     */
    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }
}
