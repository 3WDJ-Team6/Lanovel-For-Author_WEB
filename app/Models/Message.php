<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    protected $primaryKey = 'num';

    /**
     * 하나의 회원은 여러 메시지를 가질 수 있다.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
