<?php

namespace App\Models;

use Auth;
use App\Models\User;
use App\Models\IllustrationList;
use Illuminate\Database\Eloquent\Model;

class BuyerOfIllustration extends Model
{
    protected $table = "buyer_of_illustrations";

    public function storeIllustBuy(array $illust_buy_info, $num, $id)
    {
        if (count(BuyerOfIllustration::select('num_of_illustration')->where('user_id', $id)->where('num_of_illustration', (int)$num)->get()) === 0) {
            return BuyerOfIllustration::insert($illust_buy_info);
        }
    }

    public function getRecentBuy($num)
    {
        $illust_info = BuyerOfIllustration::select(
            'buyer_of_illustrations.*',
            'illust_files.*'
        )->join('illust_files', 'illust_files.num_of_illust', 'buyer_of_illustrations.num_of_illustration')
            ->where('buyer_of_illustrations.user_id', '=', Auth::user()['id'])
            ->where('buyer_of_illustrations.num_of_illustration', '=', $num)
            ->get();
    }

    /**
     * 하나의 회원은 여러 개의 일러스트 구매 테이블을 가질 수 있다.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * 하나의 일러스트는 여러 개의 일러스트 구매 테이블을 가질 수 있다.
     */
    public function illustration_list()
    {
        return $this->belongsTo('App\Models\IllustrationList');
    }
}
