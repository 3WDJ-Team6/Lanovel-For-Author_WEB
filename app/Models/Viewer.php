<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Viewer extends Model
{
    protected $table = 'viewers';

    /**
     * 하나의 회원은 하나의 뷰어 설정을 갖는다.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
