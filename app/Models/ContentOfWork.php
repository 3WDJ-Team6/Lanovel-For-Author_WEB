<?php

namespace App\Models;

use App\Models\ChapterOfWork;
use Illuminate\Database\Eloquent\Model;

class ContentOfWork extends Model
{
    protected $table = "content_of_works";
    protected $primaryKey = "subsubtitle";


    /**
     * 하나의 챕터는 여러 내용 테이블을 갖는다.
     */
    public function chapter_of_work()
    {
        return $this->belongsTo('App\Models\ChapterOfWork');
    }
}
