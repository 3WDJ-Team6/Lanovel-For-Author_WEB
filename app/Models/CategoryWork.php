<?php

namespace App\Models;

use App\Models\Work;
use Illuminate\Database\Eloquent\Model;

class CategoryWork extends Model
{
    protected $table='category_works';
    public $timestamps = false;

    /**
     * 하나의 작품은 여러개의 카테고리를 갖는다.
     */
    public function work(){
        return $this->belongsTo('App\Models\Work');
    }
}
