<?php

namespace App\Models;

use App\Models\User;
use App\Models\CommentOfIllustration;
use App\Models\IllustFile;
use App\Models\Grade;
use App\Models\BuyerOfIllustration;
use App\Models\CategoryIllustration;
use Illuminate\Database\Eloquent\Model;

class IllustrationList extends Model
{
    protected $table = 'illustration_lists';
    protected $primaryKey = 'num';

    // 새 일러스트 저장
    public function storeIllust(array $illust_info)
    {
        IllustrationList::insert($illust_info);
    }


    /**
     * 하나의 회원은 여러 일러스트를 가질 수 있다.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * 하나의 일러스트는 여러 댓글을 가질 수 있다.
     */
    public function comment_of_illustrations()
    {
        return $this->hasMany('App\Models\CommentOfIllustration');
    }

    /**
     * 하나의 일러스트는 여러 평점을 가질 수 있다.
     */
    public function grades()
    {
        return $this->hasMany('App\Models\Grade');
    }

    /**
     * 하나의 일러스트는 여러 일러스트 구매 테이블을 가질 수 있다.
     */
    public function buyer_of_illustrations()
    {
        return $this->hasMany('App\Models\BuyerOfIllustration');
    }

    /**
     * 하나의 일러스트는 여러 일러스트 카테고리를 가질 수 있다.
     */
    public function category_illustrations()
    {
        return $this->hasMany('App\Models\CategoryIllustration');
    }

    /**
     * 하나의 일러스트 작품은 여러 일러스트 파일을 가질 수 있다.
     */
    public function illust_files()
    {
        return $this->hasMany('App\Models\IllustFile');
    }
}
