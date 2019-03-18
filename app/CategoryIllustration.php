<?php

namespace App;

use App\IllustrationList;
use Illuminate\Database\Eloquent\Model;

class CategoryIllustration extends Model
{
    protected $table='category_illustrations';

    /**
     * 하나의 일러스트는 여러개의 카테고리를 갖는다.
     */
    public function illustration_list(){
        return $this->belongsTo('App\IllustrationList');
    }
}
