<?php

namespace App\Http\Controllers\WorkOut;

use App\Models\IllustrationList;
use App\Models\CategoryIllustration;
use App\Models\BuyerOfIllustration;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IllustController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = IllustrationList::select(
            // 작품번호
            'illustration_lists.*'
        )->orderBy('illustration_lists.hits_of_illustration','desc')
         ->get();

         return view('/store/home/home')->with('products',$products);
    }

    public function menuIndex($category)
    {
        $products = IllustrationList::select(
            // 작품번호
            'illustration_lists.*',
            'users.nickname'
        )->join('users', 'users.id', 'illustration_lists.user_id')
         ->join('category_illustrations', 'category_illustrations.num_of_illustration', 'illustration_lists.num')
         ->where('category_illustrations.tag', $category)
         ->orderBy('illustration_lists.hits_of_illustration','desc')
         ->get();

         return view('/store/menu/contents')->with('products',$products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
