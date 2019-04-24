<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WorkList;
use App\Models\Work;
use Illuminate\Support\Facades\DB;

class WorkListController extends Controller
{
    private $work_model = null;
    private $work_list_model = null;
    private $category_model = null;
    private $period_model = null;

    public function __construct()
    {
        // return $this->middleware('auth');
        $this->work_model = new Work();
        $this->work_list_model = new WorkList();
        // $this->category_model = new CategoryWork();
        // $this->period_model = new PeriodOfWork();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // GROUP BY works.work_title            // 참여자 수만큼 나와서 묶음
        // ORDER BY work_lists.created_at ASC   // 생성순 (필요에 따라 수정)
        $worklist = Work::select(
            'works.work_title',
            'works.introduction_of_work',
            'works.bookcover_of_work',
            DB::raw('(select count(num_of_work) FROM recommend_of_works where recommend_of_works.num_of_work = works.num) recommends'),
            DB::raw('IFNULL((select(round(avg(grades.grade),1)) from grades where grades.num_of_work = works.num AND grades.role_of_work = 1),0) grades')
        )->leftjoin('work_lists', 'works.num', '=', 'work_lists.num_of_work')
            ->where('work_lists.accept_request', 0)
            ->groupBy('works.work_title')
            ->orderBy('work_lists.created_at', 'asc')->get();

        # 제목, 소개, 표지URL, 작품 추천수, 평균 점수, 주석 부분이 태그 # WORK에서 가져오고 WORKLIST JOIN

        // SELECT nickname,roles FROM users
        // WHERE id IN (SELECT user_id FROM work_lists WHERE num_of_work=18)
        # 서브쿼리에 있는 num_of_work 의 참여자와 그 참여자의 역할 # nickname => roles

        # 추가되어야 할 query 1개씩 $url변수로 바꾸면서 json 타입으로 주면 될듯

        // 1) 작품리스트에 필요한 데이터
        // 책 이미지, 책 제목, 작가명, 일러스트레이터명, 추천수, 평점, 카테고리(해시태그), 줄거리

        // 2) 작품 페이지 (단행본)
        // 책 이미지, 책 제목, 작가명, 일러스트레이터명, 평점, 단행본|연재작 여부, 가격, 대여기간, 카테고리(해시태그), 줄거리, 업데이트 날짜

        // 3) 목차
        // 목차

        // 4) 작품 페이지 (연재작)
        // 회차 리스트 (1화, 2화, 3화 혹은 회차명),
        // 회차 업데이트 날짜


        return response()->json($worklist, 200);
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
