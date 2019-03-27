<?php

namespace App\Models;

use App\Models\User;
use App\Models\IllustrationList;
use Illuminate\Database\Eloquent\Model;

class CommentOfIllustration extends Model
{
    protected $table = 'comment_of_illustrations';
    protected $primaryKey = 'num';

    /**
     * 하나의 회원은 여러 댓글을 달 수 있다.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * 하나의 일러스트는 여러 댓글을 가질 수 있다.
     */
    public function illustration_lists()
    {
        return $this->belongsTo('App\Models\IllustrationList');
    }
}
