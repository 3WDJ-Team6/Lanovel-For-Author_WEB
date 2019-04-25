<?php

namespace App\Models;

use App\Models\Work;
use Illuminate\Database\Eloquent\Model;

class PeriodOfWork extends Model
{
    protected $table = 'period_of_works';
    public $timestamps = false;

    // 새 작품 연재주기 저장
    public function storePeriodWork(array $period_info)
    {
        PeriodOfWork::insert($period_info);
    }

    /**
     * 하나의 작품은 하나의 연재 주기를 가질 수 있다.
     */
    public function work()
    {
        return $this->belongsTo('App\Models\Work', 'num_of_work');
    }
}
