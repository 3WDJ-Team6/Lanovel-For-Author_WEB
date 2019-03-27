<?php

namespace App\Http\Controllers\WorkOut;

use App\Models\Work;
use App\Models\PeriodOfWork;
use App\Models\ChapterOfWork;
use App\Models\WorkList;
use App\Models\CategoryWork;
use App\Models\ContentOfWork;

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
    public function __construct()
    {
        /**
         * 인증 된 사용자만 editor CRUD에 접근할 수 있다.
         * 최초 접근 사용자를 위해 index, show 는 로그인 없이도 접근 가능.
         */
        // return $this->middleware('auth');
    }

    /**
     * 작업방에서 보여져아 할 데이터 값
     * 작품번호, 제목, 태그, 연재종류, 연재주기, 협업 멤버, (가격), 최근 수정시간
     */
    public function index()
    {

        //     $works = Work::select(
        //         'works.num',
        //         'works.work_title',
        //         'works.type_of_work',
        //         'works.rental_price',
        //         'works.buy_price',
        //         'works.status_of_work',
        //         'works.bookcover_of_work',
        //         'period_of_works.cycle_of_publish',
        //         'content_of_works.updated_at'
        //     )->join('period_of_works', 'works.num', '=', 'period_of_works.num_of_work')
        //      ->join('content_of_works', 'works.num', '=', 'content_of_works.num_of_work')
        //      ->joinSub($work_lists,'work_lists',function($join){
        //              $join->on('works.num' , '=' , 'work_lists.num_of_work');
        //    })->get();

        //    return $works;

        // collect($work_lists);
        // $work_list = $work_lists->where('parent', 0);

        // return $work_list;

        // SELECT * FROM works WHERE num IN (select num_of_work from work_lists WHERE user_id = '3' ;
        $works = Work::select(
            'works.num',
            'works.work_title',
            'works.type_of_work',
            'works.rental_price',
            'works.buy_price',
            'works.status_of_work',
            'works.bookcover_of_work'
        )
            // 'period_of_works.cycle_of_publish',
            // 'content_of_works.updated_at'
            // )->join('period_of_works', 'works.num', '=', 'period_of_works.num_of_work')
            //  ->join('content_of_works', 'works.num', '=', 'content_of_works.num_of_work')
            ->whereIn('works.num', function ($query) {
                $query->select('num_of_work')->from('work_lists')->whereIn('work_lists.num_of_work', function ($query2) {
                    $query2->select('user_id')->where('user_id', '=', \Auth::user()['id']);
                });
            })->orderBy('works.created_at', 'desc')->get();

        // works 테이블에서 작품번호, 제목, 연재종류, 북커버 값을 받아온다.
        // $works = Work::select(
        //     'works.num',
        //     'works.work_title',
        //     'works.type_of_work',
        //     'works.rental_price',
        //     'works.buy_price',
        //     'works.status_of_work',
        //     'works.bookcover_of_work',
        //     'period_of_works.cycle_of_publish',
        //     'content_of_works.updated_at'
        // )->join('period_of_works', 'works.num', '=', 'period_of_works.num_of_work')
        //  ->join('content_of_works', 'works.num', '=', 'content_of_works.num_of_work')
        //  ->where 
        // //  ->join('works', 'works.num', '=', 'work_lists.num_of_work')
        //  ->get();

        // return $work_lists;

        //  $work_lists = WorkList::select('user_id')->get();
        // periods 테이블에서 해당 작품 번호의 연재 주기를 받아온다.
        // $period_of_works = PeriodOfWork::select('cycle_of_publish')->get();
        //    ->join('works','period_of_works.num_of_work','=','works.num')
        //    ->value('cycle_of_publish');

        // worklists 테이블에서 해당 작품 번호의 작가 리스트(협업 멤버)를 받아온다.

        //              ->join('works','work_lists.num_of_work','=','works.num')
        //              ->value('user_id');

        // category_works 테이블에서 해당 작품 번호의 태그를 받아온다.
        // $category_works = CategoryWork::select('tag')->get();
        //                   ->join('works','category_of_works.num_of_work','=','works.num')
        //                   ->value('tag');

        // content_of_works 테이블에서 해당 작품 번호의 최종 수정 시간을 받아온다.
        // $content_of_works = ContentOfWork::select('updated_at')->get();
        //                     ->join('works','content_of_works.num_of_work','=','works.num')
        //                     ->value('updated_at');

        return view('index')->with('works', $works);
        // ->with('period_of_works',$period_of_works)
        // ->with('work_lists',$work_lists)
        // ->with('category_works',$category_works)
        // ->with('content_of_works',$content_of_works);
    }

    /**
     * 작품 추가
     * 
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { }

    /**
     * 작품 저장
     * 받아올 정보 - 제목, 태그, 종류(회차 or 단행본 or 단편), 가격, 작품소개, 북커버, 연재상태(1),
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $works = new Work();

        // 제목, 종류, 가격(대여,구매), 작품소개, 북커버
        $works->work_title = $request->get('work_title');
        $works->type_of_work = $request->get('type_of_work');
        $works->rental_price = $request->get('rental_price');
        $works->buy_price = 300;
        $works->hits_of_work = 0;
        // $works->buy_price = $request->buy_price;
        $works->introduction_of_work = $request->get('introduction_of_work');
        $works->bookcover_of_work = $request->get('bookcover_of_work');
        $works->status_of_work = 1;
        $works->save();

        // 현재 로그인 한 사용자의 회원번호를 work_lists 테이블의 user_id 로 저장한다.
        $work_lists = new WorkList();
        $work_lists->num_of_work = $works->num;
        $work_lists->last_time_of_working = "test";
        $work_lists->user_id = \Auth::user()['id'];
        $work_lists->save();

        $category_works = new CategoryWork();
        // 태그
        $category_works->num_of_work = $works->num;
        $category_works->tag = $request->get('tag');
        $category_works->save();

        return redirect('/')->with('message', "success");
    }

    /**
     * 챕터 목록 화면에서 필요한 것 
     * 작품 제목, 작품 설명, 챕터 이름, 연재 상태, 협업 멤버, 업데이트 시간
     */
    public function chapter_index($num)
    {
        // 챕터 num 값 받아옴!!!!
        $works = Work::select(
            'works.num',
            'works.work_title',
            'works.introduction_of_work',
            'works.status_of_work',
            'chapter_of_works.subtitle',
            'chapter_of_works.num_of_work',
            'chapter_of_works.num'
        )
            ->join('chapter_of_works', 'chapter_of_works.num_of_work', '=', 'works.num')
            ->where('works.num', '=', $num)->get();

        return view('editor.main.chapter')
            ->with('works', $works)->with('num', $num);
    }

    public function chapter_create($num)
    {
        return view('editor.main.popup_chapter')->with('num', $num);
    }

    public function addChapter(Request $request, $num)
    {

        $chapter_of_works = new ChapterOfWork();
        // 현재 작품 번호를 받아온다.
        $chapter_of_works->num_of_work = $num;
        // 회차 제목 추가
        $chapter_of_works->subtitle = $request->get('subtitle');

        $chapter_of_works->save();

        return redirect('editor.main.chapter' . $num)->with('message', 'success');
    }

    /**
     * 
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
     * 작품 수정 화면
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($num)
    {
        $works = Work::where('num', $num)->first();

        return view('editor/main/book_add')->with('works', $works);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $works = Work::where('num', $request->num)->first();

        // 제목, 종류, 가격(대여,구매), 작품소개, 북커버
        $works->work_title = $request->get('work_title');
        $works->type_of_work = $request->get('type_of_work');
        $works->rental_price = $request->get('rental_price');
        $works->buy_price = 300;
        $works->hits_of_work = 0;
        // $works->buy_price = $request->buy_price;
        $works->introduction_of_work = $request->get('introduction_of_work');
        $works->bookcover_of_work = $request->get('bookcover_of_work');
        $works->status_of_work = 1;
        $works->save();

        $category_works = new CategoryWork();
        // 태그
        $category_works->num_of_work = $works->num;
        $category_works->tag = $request->get('tag');
        $category_works->save();

        return redirect('/')->with('message', "update success");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($num)
    {
        //
    }
}
