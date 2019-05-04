<?php

namespace App\Http\View\Composers;

use Auth;
use Illuminate\View\View;
use App\Models\CartOfIllustration;
use Illuminate\Support\Facades\DB;

class cartComposer
{

    public function __construct()
    { }

    public function compose(View $view)
    {

        $cartNum = CartOfIllustration::select(
            DB::raw('COUNT(cart_of_illustrations.num_of_illust) incart'),
            DB::raw('SUM(illustration_lists.price_of_illustration) sumprice')
        )->join('illustration_lists', 'cart_of_illustrations.num_of_illust', 'illustration_lists.num')
            ->where('cart_of_illustrations.user_id', Auth::user()['id'])
            ->first();

        $cartProducts = CartOfIllustration::select(
            'cart_of_illustrations.*',
            'illustration_lists.*',
            'illust_files.*'
        )->join('illustration_lists', 'cart_of_illustrations.num_of_illust', 'illustration_lists.num')
            ->join('illust_files', 'cart_of_illustrations.num_of_illust', 'illust_files.num_of_illust')
            ->groupBy('illust_files.num_of_illust')
            ->orderBy('illust_files.id', 'desc')
            ->where('cart_of_illustrations.user_id', Auth::user()['id'])
            ->get();

        $view->with('cartProducts', $cartProducts)->with('cartNum', $cartNum);
    }
}
