<?php

namespace App\Http\View\Composers;

use Auth;
use Illuminate\View\View;
use App\Models\CartOfIllustration;
use App\Models\Message;
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

        $invite_messages = Message::select(
            'messages.num',
            'messages.message_title',
            'messages.message_content',
            'u2.nickname as from_id',
            DB::raw("DATE_FORMAT(messages.created_at, '%y-%m-%d %h:%i') as created_ata"),
            DB::raw("(SELECT COUNT(*) FROM messages WHERE condition_message = 0) count")
        )->leftjoin('users as u1', 'u1.id', 'messages.to_id')
        ->leftjoin('users as u2', 'u2.id', 'messages.from_id')
        ->where('message_title', 'like', '%作品に招待しました。')
        ->where('to_id', '=', Auth::user()['id'])
        ->get();

        $view->with('cartProducts', $cartProducts)->with('cartNum', $cartNum)->with('invite_messages',$invite_messages);
    }
}
