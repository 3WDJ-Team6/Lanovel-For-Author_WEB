<?php

namespace App\Models;

use App\Models\Work;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = 'contracts';
    protected $primaryKey = 'num';

    /**
     * 하나의 작품은 하나의 계약서를 갖는다.
     */
    public function work()
    {
        return $this->belongsTo('App\Models\Work');
    }
}
