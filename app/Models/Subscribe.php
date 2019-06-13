<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    protected $table = 'subscribes';
    public $timestamps = false;


    protected $primaryKey = null;
    public $incrementing = false;


    protected $fillable = array('reader_id', 'author_id');

    /**
     * 하나의 독자는 여러 구독 테이블을 가질 수 있다.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
