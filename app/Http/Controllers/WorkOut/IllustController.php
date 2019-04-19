<?php

namespace App\Http\Controllers\WorkOut;

use App\Models\IllustrationList;
use App\Models\CategoryIllustration;
use App\Models\BuyerOfIllustration;
use App\Models\User;
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
            'illustration_lists.*',
            'users.nickname'
        )->join('users', 'users.id', 'illustration_lists.user_id')
         ->orderByRaw('illustration_lists.hits_of_illustration','desc')
         ->limit(5)
         ->get();
      
        return view('/store/home/home')->with('products', $products);
    }

    public function menuIndex($category, $moreCategory)
    {
        
        $products = IllustrationList::select(
            // 작품번호
            'illustration_lists.*',
            'users.nickname'
        )->join('users', 'users.id', 'illustration_lists.user_id')
         ->join('category_illustrations', 'category_illustrations.num_of_illustration', 'illustration_lists.num')
         ->where('category_illustrations.tag', $category)
         ->where('category_illustration.moreTag', $moreCategory)
         ->get();


        return view('/store/menu/contents')->with('products', $products);
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

        // 작품 저장
        $illust_info = array([
            // 제목
            'illustration_title' => $request->get('illustration_title'),
            // 연재종류
            'type_of_work' => $request->get('radio_T'),
            // 대여 및 구매 가격
            'price_of_illustration' => $request->get('price_of_illustration'),
            'buy_price' => $request->get('buy_price'),
            // 조회수 (default = 0)
            'hits_of_work' => 0,
            // 작품 소개
            'introduction_of_work' => $request->get('introduction_of_work'),
            // 북커버 (파일명)
            'bookcover_of_work' => $bookCoverUrl . $name,
            // 연재 상태 (default = 1 (연재중))
            'status_of_work' => 1,
            // 생성 날짜 (현재)
            'created_at' => Carbon::now()
        ]);
        $this->work_model->storeWork($work_info);

        $num = Work::select('num')->orderBy('created_at', 'DESC')->first()['num'];

        // 태그 저장
        $work_tag_info = array([
            'num_of_work' => $num,
            'tag' => $request->get('tag')
        ]);
        $this->category_model->storeTag($work_tag_info);

        // 현재 로그인 한 사용자를 작품 리스트에 추가
        $work_list_info = array([
            'num_of_work' => $num,
            'last_time_of_working' => "test",
            'user_id' => Auth::user()['id']
        ]);
        $this->work_list_model->storeWorklist($work_list_info);
        return redirect('/')->with('message', "success");
    }
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
