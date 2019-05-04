<?php

namespace App\Models;

use App\Models\User;
use App\Models\Work;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $table = 'rentals';

    public $primaryKey = 'num';

    # request->all()함수를 사용했을 시 할당할 데이터 (대량할당) 엘로퀀트 쓸거면 필요
    protected $fillable = [
        'num', 'user_id', 'num_of_work', 'due_of_rental', 'file_path', 'chapter_of_work'
    ];

    /**
     * 하나의 회원은 여러 대여 테이블을 가질 수 있다.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * 하나의 작품은 여러 대여 테이블을 가질 수 있다.
     */
    public function work()
    {
        return $this->belongsTo('App\Models\Work');
    }
}
