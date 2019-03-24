<?php

namespace App\Models;

use App\Models\Work;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class WorkList extends Model
{
    protected $table = 'work_lists';
    
    /**
     * 하나의 회원은 여러 작업 리스트에 포함 될 수 있다.
     * 하나의 작업 리스트는 하나의 회원을 포함한다.
     * 회원 : 작업 리스트 = 일 : 다
     */
    public function user(){
        return $this->belongsTo('App\User');
    }
    
    /**
     * 하나의 작품은 여러 작업 리스트를 갖는다. 
     * 하나의 작업 리스트는 하나의 작품을 갖는다.
     * 작품 : 작업리스트 = 일 : 다
     */
    public function work(){
        return $this->belongsTo('App\Work');
    }

}
