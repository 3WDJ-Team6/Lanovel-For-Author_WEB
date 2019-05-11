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
        // 1) 작품리스트에 필요한 데이터
        // 책 이미지, 책 제목, 작가명, 일러스트레이터명, 추천수, 평점, 카테고리(해시태그), 줄거리
        $worklist = Work::select(
            'works.num',
            'chapter_of_works.num as num_of_chapter',
            'works.work_title',
            'chapter_of_works.subtitle',
            'works.introduction_of_work',
            'works.bookcover_of_work',
            DB::raw('(select count(num_of_work) FROM recommend_of_works where recommend_of_works.num_of_work = works.num) recommends'),
            DB::raw('IFNULL((select(round(avg(grades.grade),1)) from grades where grades.num_of_work = works.num AND grades.role_of_work = 1),0) grades'),
            DB::raw("(select group_concat(case when users.roles = 1 then 'Reader' when users.roles = 2 then 'Author' when users.roles = 3 then 'Illustrator' end, ' : ' , nickname ) from users where users.id in (select work_lists.user_id FROM work_lists WHERE work_lists.num_of_work = works.num)) participant"),
            DB::raw('(select group_concat(category_works.tag) from category_works where category_works.num_of_work = works.num) tag')
        )->leftjoin('work_lists', 'works.num', '=', 'work_lists.num_of_work')
            ->leftjoin('users', 'work_lists.user_id', '=', 'users.id')
            ->leftjoin('category_works', 'works.num', '=', 'category_works.num_of_work')
            ->leftjoin('chapter_of_works', 'works.num', '=', 'chapter_of_works.num_of_work')
            ->where('work_lists.accept_request', '=', 0) # 0번이 작업방 참여 수락한 사람
            ->whereNotNull('chapter_of_works.num')
            ->Where('works.type_of_work', '=', 2)        # 작품이 단행본인 것만 (회차, 단행본, 단편 중)
            ->groupBy('chapter_of_works.num')
            ->orderBy('work_lists.created_at', 'asc')->get();

        # 제목, 소개, 표지URL, 작품 추천수, 평균 점수, 주석 부분이 태그 # WORK에서 가져오고 WORKLIST JOIN

        // SELECT nickname,roles FROM users
        // WHERE id IN (SELECT user_id FROM work_lists WHERE num_of_work=18)
        # 서브쿼리에 있는 num_of_work 의 참여자와 그 참여자의 역할 # nickname => roles

        # 추가되어야 할 query 1개씩 $url변수로 바꾸면서 json 타입으로 주면 될듯


        // 보류 6월 중 구현
        // 4) 작품 페이지 (연재작)
        // 회차 리스트 (1화, 2화, 3화 혹은 회차명),
        // 회차 업데이트 날짜

        return response()->json($worklist, 200, [], JSON_PRETTY_PRINT);
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
    public function show($workNum, $chapterNum, $userId)   # 작품을 누르면 작품 페이지로 이동
    {
        // 받아와야할 변수 작품번호(지금 18들어가있는곳), 챕터번호(23번), 현재 로그인중인 사용자(9번), type_of_work = 2 (단행본일 때)
        // 2) 작품 페이지 (단행본) + 3번 목차
        // 책 이미지, 책 제목, 작가명, 일러스트레이터명, 평점, 단행본|연재작 여부, 가격, 대여기간, 카테고리(해시태그), 줄거리, 업데이트 날짜

        $works = Work::select(
            'works.num',
            'works.work_title',
            'works.introduction_of_work',
            'works.bookcover_of_work',
            DB::raw("(case when works.type_of_work = 1 then 'short story' when works.type_of_work = 2 then 'book' when works.type_of_work = 3 then 'episode' end) type_of_work"),
            'works.rental_price',
            'works.buy_price',
            DB::raw('IFNULL((select(round(avg(grades.grade),1)) from grades where grades.num_of_work = works.num AND grades.role_of_work = 1),0) grades'),
            DB::raw("(select group_concat(nickname) from users where users.id in (SELECT user_id FROM work_lists WHERE work_lists.num_of_work = works.num AND users.roles=2)) author"),
            DB::raw("(select group_concat(nickname) from users where users.id in (SELECT user_id FROM work_lists WHERE work_lists.num_of_work = works.num AND users.roles=3)) illustrator"),
            DB::raw('(select group_concat(category_works.tag) from category_works where category_works.num_of_work = works.num) tag'),
            DB::raw('(select count(num_of_work) FROM recommend_of_works where recommend_of_works.num_of_work = works.num) recommends'),
            DB::raw("if((select count(recommend_of_works.num_of_work) FROM recommend_of_works WHERE recommend_of_works.num_of_work = works.num AND recommend_of_works.user_id = $userId),'t','f') recommends_or_not"),
            DB::raw("IFNULL((select if(ISNULL(due_of_rental),'buy','rental') FROM rentals WHERE rentals.user_id = $userId AND rentals.chapter_of_work = $chapterNum),'0') check_buy_or_ren"),
            DB::raw('(select count(*) from subscribe_or_interests WHERE subscribe_or_interests.role_of_work = 1) subscribe_count'),
            DB::raw("if((select count(*) from subscribe_or_interests WHERE subscribe_or_interests.role_of_work = 1 AND subscribe_or_interests.user_id = $userId),'t','f') sub_or_not"),
            DB::raw("if((select count(*) from subscribe_or_interests WHERE subscribe_or_interests.role_of_work = 2 AND subscribe_or_interests.user_id = $userId),'t','f' ) ins_or_not"),
            DB::raw('(select users.profile_photo from users where users.id in(select user_id from work_lists where num_of_work = 18) LIMIT 1) author_profile_photo'),
            DB::raw("(select group_concat(content_of_works.subsubtitle) from content_of_works where content_of_works.num_of_chapter = $chapterNum) content_title_group"),
            DB::raw("date_format(MAX(greatest(works.created_at , ifnull(content_of_works.created_at,''))),'%y-%m-%d') lastupdate")
        )->leftjoin('work_lists', 'works.num', '=', 'work_lists.num_of_work')
            ->leftjoin('category_works', 'works.num', '=', 'category_works.num_of_work')
            ->leftjoin('content_of_works', 'works.num', '=', 'content_of_works.num_of_work')
            ->leftjoin('subscribe_or_interests', 'works.num', '=', 'subscribe_or_interests.num_of_work')
            ->where('work_lists.accept_request', '=', 0)
            ->where('works.num', '=', $workNum)
            ->where('works.type_of_work', '=', 2)
            ->groupBy('works.num')
            ->orderBy('work_lists.created_at', 'asc')->get();

        return response()->json($works, 200, [], JSON_PRETTY_PRINT);
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
