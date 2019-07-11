<?php

namespace App\Models;

use App\Models\Work;
use App\Models\IllustrationList;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table = 'grades';
    public $timestamps = false;


    // 새 평점 저장
    public function storeGrade(array $grade_info)
    {
        Grade::insert($grade_info);
    }

    /**
     * 하나의 작품은 여러 개의 평점을 가질 수 있다.
     */
    public function work()
    {
        return $this->belongsTo('App\Models\Work');
    }

    /**
     * 하나의 회원은 여러 개의 평점을 달 수 있다.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * 하나의 일러스트는 여러 개의 평점을 가질 수 있다.
     */
    public function illustration_list()
    {
        return $this->belongsTo('App\Models\IllustrationList');
    }
}
