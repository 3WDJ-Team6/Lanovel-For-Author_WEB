<?php

namespace App\Models;

use App\Request;
use App\Models\Work;
// use App\Models\CategoryWork;
use Illuminate\Database\Eloquent\Model;

class CategoryWork extends Model
{
    protected $table = 'category_works';
    public $timestamps = false;

    // 새 태그 저장
    public function storeTag(array $work_tag_info)
    {
        CategoryWork::insert($work_tag_info);
    }

    /**
     * 하나의 작품은 여러개의 카테고리를 갖는다.
     */
    public function work()
    {
        return $this->belongsTo('App\Models\Work', 'num_of_work');
    }
}
