<?php

namespace App\Models;

use App\Models\IllustrationList;
use Illuminate\Database\Eloquent\Model;

class CategoryIllustration extends Model
{
    protected $table = 'category_illustrations';

    public function storeTag(array $illust_tag_info)
    {
        CategoryIllustration::insert($illust_tag_info);
    }

    /**
     * 하나의 일러스트는 여러개의 카테고리를 갖는다.
     */
    public function illustration_list()
    {
        return $this->belongsTo('App\Models\IllustrationList');
    }
}
