<?php

namespace App\Http\Controllers\WorkOut;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * 작업방 컨트롤러 입니다. (작업방 보기, 작품 추가, 수정, 삭제 매소드)
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        /**
         * 인증 된 사용자만 editor CRUD에 접근할 수 있다.
         * 최초 접근 사용자를 위해 index, show 는 로그인 없이도 접근 가능.
         */
        return $this->middleware('auth');
    }

    /**
     * 작업방에서 보여져아 할 데이터 값
     * 작품번호, 제목, 태그, 연재종류, 연재주기, 협업 멤버, (가격), 최근 수정시간
     */
    public function index()
    {
        // works 테이블에서 작품번호, 제목, 연재종류, 북커버 값을 받아온다.
        $works = Work::select('works.num', 'works.work_title', 'works.type_of_work', 'works.bookcover_of_work');

        // periods 테이블에서 해당 작품 번호의 연재 주기를 받아온다.
        $period_of_works = PeriodOfWork::table('period_of_works')
                           ->join('works','period_of_works.num_of_work','=','works.num')
                           ->value('cycle_of_publish');

        // worklists 테이블에서 해당 작품 번호의 작가 리스트(협업 멤버)를 받아온다.
        $work_lists = WorkList::table('worklists')
                     ->join('works','worklists.num_of_work','=','works.num')
                     ->value('user_id');

        // category_works 테이블에서 해당 작품 번호의 태그를 받아온다.
        $category_works = CategoryWork::table('category_works')
                          ->join('works','category_of_works.num_of_work','=','works.num')
                          ->value('tag');
        
        // content_of_works 테이블에서 해당 작품 번호의 최종 수정 시간을 받아온다.
        $content_of_works = ContentOfWork::table('content_of_works')
                            ->join('works','content_of_works.num_of_work','=','works.num')
                            ->value('updated_at');

        return view('editor.main.index')->with('works',$works)
                                        ->with('period_of_works',$period_of_works)
                                        ->with('work_lists',$worklists)
                                        ->with('category_works',$category_works)
                                        ->with('content_of_works',$content_of_works);
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
