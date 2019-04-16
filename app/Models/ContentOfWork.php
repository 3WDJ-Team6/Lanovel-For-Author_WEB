<?php

namespace App\Models;

use App\Models\ChapterOfWork;
use App\Models\Memo;
use Illuminate\Database\Eloquent\Model;

class ContentOfWork extends Model
{
    protected $table = "content_of_works";
    protected $primaryKey = "num";


    /**
     * 하나의 챕터는 여러 내용 테이블을 갖는다.
     */
    public function chapter_of_work()
    {
        return $this->belongsTo('App\Models\ChapterOfWork');
    }

    /**
     * 하나의 챕터는 여러 메모 테이블을 갖는다.
     */
    public function memos()
    {
        return $this->hasMany('App\Models\memo');
    }
}
