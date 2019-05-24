<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WorkList;
use App\Models\Work;
use App\Models\Rental;
use Illuminate\Support\Facades\DB;
use App\Models\RecommendOfWork;
use App\Models\SubscribeOrInterest;

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
            // 'chapter_of_works.num as num_of_chapter',    //챕터 번호
            'works.work_title',
            // 'chapter_of_works.subtitle',                 //챕터 제목
            'works.introduction_of_work',
            'works.bookcover_of_work',
            DB::raw('(select count(num_of_work) FROM recommend_of_works where recommend_of_works.num_of_work = works.num) recommends'),
            DB::raw('IFNULL((select(round(avg(grades.grade),1)) from grades where grades.num_of_work = works.num AND grades.role_of_work = 1),0) grades'),
            // DB::raw("(select group_concat(case when users.roles = 1 then 'Reader' when users.roles = 2 then 'Author' when users.roles = 3 then 'Illustrator' end, ' : ' , nickname ) from users where users.id in (select work_lists.user_id FROM work_lists WHERE work_lists.num_of_work = works.num)) participant"),
            DB::raw("(select group_concat(nickname) from users where users.id in (SELECT user_id FROM work_lists WHERE work_lists.num_of_work = works.num AND users.roles=2)) author"),
            DB::raw("(select group_concat(nickname) from users where users.id in (SELECT user_id FROM work_lists WHERE work_lists.num_of_work = works.num AND users.roles=3)) illustrator"),
            DB::raw('(select group_concat(category_works.tag) from category_works where category_works.num_of_work = works.num) tag')
        )->leftjoin('work_lists', 'works.num', '=', 'work_lists.num_of_work')
            ->leftjoin('users', 'work_lists.user_id', '=', 'users.id')
            ->leftjoin('category_works', 'works.num', '=', 'category_works.num_of_work')
            ->leftjoin('chapter_of_works', 'works.num', '=', 'chapter_of_works.num_of_work')
            ->where('work_lists.accept_request', '=', 0) # 0번이 작업방 참여 수락한 사람
            ->whereNotNull('chapter_of_works.num')
            ->Where('works.type_of_work', '=', 2)        # 작품이 단행본인 것만 (회차, 단행본, 단편 중)
            ->groupBy('chapter_of_works.num_of_work')
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
    public function show($workNum, $userId)   # 작품을 누르면 작품 페이지로 이동
    {
        // 받아와야할 변수 작품번호(지금 18들어가있는곳), 챕터번호(23번), 현재 로그인중인 사용자(9번), type_of_work = 2 (단행본일 때)
        // 2) 작품 페이지 (단행본) + 3번 목차
        // 책 이미지, 책 제목, 작가명, 일러스트레이터명, 평점, 단행본|연재작 여부, 가격, 대여기간, 카테고리(해시태그), 줄거리, 업데이트 날짜
        $authorId = '';
        $works = Work::select(
            'works.num',
            'works.work_title',
            'works.introduction_of_work',
            'works.bookcover_of_work',
            DB::raw("(case when works.type_of_work = 1 then 'short story' when works.type_of_work = 2 then 'book' when works.type_of_work = 3 then 'episode' end) type_of_work"),
            'works.rental_price',
            'works.buy_price',
            DB::raw('IFNULL((select(round(avg(grades.grade),1)) from grades where grades.num_of_work = works.num AND grades.role_of_work = 1),0) grades'),
            // DB::raw("(select group_concat(case when users.roles = 1 then 'Reader' when users.roles = 2 then 'Author' when users.roles = 3 then 'Illustrator' end, ' : ' , nickname ) from users where users.id in (select work_lists.user_id FROM work_lists WHERE work_lists.num_of_work = works.num)) participant"),
            DB::raw("(select group_concat(nickname) from users where users.id in (SELECT user_id FROM work_lists WHERE work_lists.num_of_work = works.num AND users.roles=2)) author"),
            DB::raw("(select group_concat(nickname) from users where users.id in (SELECT user_id FROM work_lists WHERE work_lists.num_of_work = works.num AND users.roles=3)) illustrator"),
            DB::raw('(select group_concat(category_works.tag) from category_works where category_works.num_of_work = works.num) tag'),
            DB::raw('(select count(num_of_work) FROM recommend_of_works where recommend_of_works.num_of_work = works.num) recommends'),
            DB::raw("if((select count(recommend_of_works.num_of_work) FROM recommend_of_works WHERE recommend_of_works.num_of_work = works.num AND recommend_of_works.user_id = $userId),'t','f') recommends_or_not"),
            //DB::raw("IFNULL((select if(ISNULL(due_of_rental),'buy','rental') FROM rentals WHERE rentals.user_id = $userId AND rentals.chapter_of_work = $chapterNum),'0') check_buy_or_ren"), #?
            DB::raw('(select count(*) from subscribe_or_interests WHERE subscribe_or_interests.role_of_work = 1) subscribe_count'),
            DB::raw("if((select count(*) from subscribe_or_interests WHERE subscribe_or_interests.role_of_work = 1 AND subscribe_or_interests.user_id = $userId),'t','f') sub_or_not"),
            DB::raw("if((select count(*) from subscribe_or_interests WHERE subscribe_or_interests.role_of_work = 2 AND subscribe_or_interests.user_id = $userId),'t','f' ) ins_or_not"),
            DB::raw('(select users.profile_photo from users where users.id in(select user_id from work_lists where num_of_work = 18) LIMIT 1) author_profile_photo'),
            //DB::raw("(select group_concat(content_of_works.subsubtitle) from content_of_works where content_of_works.num_of_chapter = $chapterNum) content_title_group"),
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

    public function update(Request $request, $point)
    {
        // Reantal::selete('due_of_lental')->where('','')->get();
        return '보낸 리퀘스트 :' . $request . ':' . $point;
    }
    public function selection(Request $request)
    {
        // 보유 포인트와 작품 구매 가격 비교
        $buyPoint = User::select(
            DB::raw("(select(IF(point>works.buy_price, 'true', 'false')) from users JOIN works ON works.num =" . $num . " WHERE users.id=" . Auth::user()['id'] . ") canBuy")
        )->where('users.id', Auth::user()['id'])
            ->get();

        // 보유 포인트와 작품 대여 가격 비교
        $rentalPoint = User::select(
            DB::raw("(select(IF(point>works.rental_price, 'true', 'false')) from users JOIN works ON works.num =" . $num . " WHERE id=" . Auth::user()['id'] . ") canRental")
        )->where('users.id', Auth::user()['id'])
            ->get();

        // 대여 시 포인트 차감
        $rentalPointM = User::where('id', Auth::user()['id'])
            ->update(
                ['point' => DB::raw("point - (select rental_price from works where num =" . $num . ")")]
            );

        // 구매 시 포인트 차감
        $buyPointM = User::where('id', Auth::user()['id'])
            ->update(
                ['point' => DB::raw("point - (select buy_price from works where num =" . $num . ")")]
            );

        // 134 = 작품 번호 22 = 유저번호 0,1,2 = 구독,관심,좋아요 구분
        $result = SubscribeOrInterest::select(
            DB::raw("IF(role_of_work = 0, 'true', 'false') subOrInterstOrLike")
        )->where('subscribe_or_interests.user_id', Auth::user()['id'])
            ->where('subscribe_or_interests.num_of_work', $num)
            ->groupBy('subscribe_or_interests.user_id')
            ->groupBy('subscribe_or_interests.num_of_work')->get();

        $selection = '';
        switch ($request) {
            case 'interested_selected':
                // 관심작품 여부가 TRUE 일 때 관심작품 취소
                $deleteInterest = SubscribeOrInterest::where('subscribe_or_interest.user_id', Auth::user()['id'])
                    ->where('subscribe_or_interest.num_of_work', $num)
                    ->where('subscribe_or_interest.role_of_work', 1)
                    ->delete();
                break;
            case 'interested_unselected':
                // 관심작품 여부가 FALSE 일 때 관심작품 신청
                $addSub = SubscribeOrInterest::insert(
                    ['num_of_work' => $num, 'user_id' => Auth::user()['id'], 'role_of_work' => 1]
                );
                break;

            case 'sub_selected':
                // 구독 여부가 TRUE 일 때 구독 취소
                $deleteSub = SubscribeOrInterest::where('subscribe_or_interest.user_id', Auth::user()['id'])
                    ->where('subscribe_or_interest.num_of_work', $num)
                    ->where('subscribe_or_interest.role_of_work', 0)
                    ->delete();
                break;

            case 'sub_unselected':
                // 구독 여부가 FALSE 일 때 구독 신청
                $addSub = SubscribeOrInterest::insert(
                    ['num_of_work' => $num, 'user_id' => Auth::user()['id'], 'role_of_work' => 0]
                );
                break;

                //추천
            case 'like_selected':
                // 좋아요 여부가 TRUE 일 때 좋아요 취소
                $deleteLike = SubscribeOrInterest::where('subscribe_or_interest.user_id', Auth::user()['id'])
                    ->where('subscribe_or_interest.num_of_work', $num)
                    ->where('subscribe_or_interest.role_of_work', 2)
                    ->delete();
                break;
            case 'like_unselected':
                // 좋아요 여부가 FALSE 일 때 좋아요 신청
                $addSub = SubscribeOrInterest::insert(
                    ['num_of_work' => $num, 'user_id' => Auth::user()['id'], 'role_of_work' => 2]
                );
                break;
        }

        // http://13.209.153.194/selectionRequest?key=value
        // 아래는 key = value  ↔ selection = value
        // 패러미터 value 값을 아래와 같이 보내면, 해당 value 값에 따라, db상의 값을 update 한다.

        // 관심작품여부 O : selection="interested_selected"
        // 관심작품여부 X : selection="interested_unselected"

        // 좋아요 여부 O : selection = "like_selected"
        // 좋아요 여부 X : selection = "like_unselected"

        // 구독 여부 O : selection = "sub_selected"
        // 구독 여부 X : selection = "sub_unselected"
        return $request . ':' . $id;
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
