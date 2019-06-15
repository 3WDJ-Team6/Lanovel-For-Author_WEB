<?php

namespace App\Models;

use App\Models\User;
use App\Models\Work;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';
    protected $primaryKey = 'num';

    // 새 리뷰 저장
    public function storeReview(array $review_info)
    {
        Review::insert($review_info);
    }

    /**
     * 하나의 작품은 여러 리뷰를 가질 수 있다.
     */
    public function work()
    {
        return $this->belongsTo('App\Models\Work');
    }

    /**
     * 하나의 사용자는 여러 리뷰를 가질 수 있다.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
