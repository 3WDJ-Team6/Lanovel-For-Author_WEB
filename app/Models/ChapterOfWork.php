<?php

namespace App\Models;

use App\Models\Work;
use App\Models\ContentOfWork;
use App\Models\Memo;
use Illuminate\Database\Eloquent\Model;

class ChapterOfWork extends Model
{
    protected $table = "chapter_of_works";
    public $timestamps = false;
    protected $primaryKey = 'num';


    /**
     * 하나의 작품은 여러 챕터를 가질 수 있다.
     */
    public function work()
    {
        return $this->belongsTo('App\Models\Work');
    }

    /**
     * 하나의 챕터는 여러 내용을 가질 수 있다.
     */

    public function content_of_works()
    {
        return $this->hasMany('App\Models\ContentOfWork');
    }

    /**
     * 하나의 챕터는 여러 메모를 가질 수 있다.
     */

    public function memos()
    {
        return $this->hasMany('App\Models\Memo');
    }
}
