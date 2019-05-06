<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\IllustrationList;

class LikeOfIllustration extends Model
{
    protected $table = 'like_of_illustrations';

    public function storeLikeIllust(array $like_info)
    {
        LikeOfIllustration::insert($like_info);
    }

    /**
     * 하나의 작품은 여러 좋아요를 가질 수 있다.
     */
    public function illustration_list()
    {
        return $this->belongsTo(IllustrationList::class);
    }

    /**
     * 하나의 회원은 여러 좋아요 작품을 가질 수 있다.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
