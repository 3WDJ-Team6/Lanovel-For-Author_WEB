<?php

namespace App\Models;

use App\Models\User;
use App\Models\Work;
use App\Models\ChapterOfWork;
use App\Models\ContentOfWork;
use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    protected $table = 'memos';
    protected $primaryKey = 'num';
    public $timestamps = false;

    /**
     * 한 회원은 여러 메모 테이블을 가질 수 있다.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * 한 작품은 여러 메모 테이블을 가질 수 있다.
     */
    public function work()
    {
        return $this->belongsTo('App\Models\Work');
    }

    /**
     * 한 챕터는 여러 메모 테이블을 가질 수 있다.
     */
    public function ChapterOfwork()
    {
        return $this->belongsTo('App\Models\chapter_of_works');
    }

    /**
     * 한 회차는 여러 메모 테이블을 가질 수 있다.
     */
    public function ContentOfWork()
    {
        return $this->belongsTo('App\Models\content_of_works');
    }
}
