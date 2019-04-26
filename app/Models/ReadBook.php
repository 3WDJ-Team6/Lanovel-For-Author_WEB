<?php

namespace App\WorkOut;

use Illuminate\Database\Eloquent\Model;

class ReadBook extends Model
{
    protected $table = 'read_books';
    public $timestamps = false;

    /**
     * 하나의 작품은 여러 readbook 테이블을 가질 수 있다.
     */
    public function work()
    {
        return $this->belongsTo('App\Models\Work');
    }
}
