<?php

namespace App\Models;

use App\Models\User;
use App\Models\Work;
use Illuminate\Database\Eloquent\Model;

class CommentOfWork extends Model
{
    protected $table = 'comment_of_works';
    protected $primaryKey = 'num';

    /**
     * 하나의 회원은 여러 댓글을 달 수 있다.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * 하나의 작품은 여러 댓글을 가질 수 있다.
     */
    public function work()
    {
        return $this->belongsTo('App\Models\Work');
    }

    public function getContent()
    {
        return $content = ContentOfWork::where('num', 245)->get();
    }
}
