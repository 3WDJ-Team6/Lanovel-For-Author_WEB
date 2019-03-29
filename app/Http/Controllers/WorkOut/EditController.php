<?php

namespace App\Http\Controllers\WorkOut;

use Auth;

use App\Models\ContentOfWork;
use App\Models\ChapterOfWork;
use App\Models\Work;
use App\Models\WorkList;
use App\Models\Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EditController extends Controller
{
    /**
     * 목차 리스트 및 에디터 컨트롤러 입니다. (목차 리스트 보기, 목차 추가, 에디터 작성, 저장, 삭제, 수정 등)
    * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        /**
         * 인증 된 사용자만 목차 리스트 및 에디터에 접근할 수 있다.
         */
        // return $this->middleware('auth');
    }

    /**
    * 목차 리스트 보기
    * 필요한 데이터 - 챕터 제목(or 권수), 회차 제목(or 회차수), 작품 생성 시각, 작품 최종 수정 시각, 
    */
    public function index($num)
    {
        // $works = Work::select(
        //         'works.num',
        //         'works.work_title',
        //         'chapter_of_works.num',
        //         'chapter_of_works.subtitle',
        //         'content_of_works.subsubtitle',
        //         'content_of_works.num_of_work',
        //         'content_of_works.num_of_chapter',
        //         'content_of_works.num'
        // )
        //         ->join('chapter_of_works', 'chapter_of_works.num_of_work', '=', 'works.num')
        //         ->where('works.num','=',$num)
        //         ->orderBy('works.created_at','desc')->get();

        $chapter_of_works = ChapterOfWork::select(
            'chapter_of_works.num',
            'chapter_of_works.subtitle',
            'content_of_works.num',
            'content_of_works.num_of_chapter',
            'content_of_works.subsubtitle',
            'content_of_works.created_at'
        )
            ->join('content_of_works', 'content_of_works.num_of_chapter', '=', 'chapter_of_works.num')
            ->where('chapter_of_works.num', '=', $num)
            ->get();

        // return $chapter_of_works;
        // ->orderBy('chapter_of_works.created_at','desc')->get();

        //  $chapter_of_works = ChapterOfWork::select('chapter_of_works.subtitle')
        //                      ->join('works','chapter_of_works.num_of_work','=',$num)->get();

        return view('editor.main.list')
            ->with('chapter_of_works', $chapter_of_works)->with('num', $num);
        //    ->with('work_lists', $work_lists)
        //    ->with('templates', $templates);
        //    ->with('episodes', $episodes);
    }

    public function content_create($num)
    {
        return view('editor.main.popup')->with('num', $num);
    }

    /**
     * 목차 추가 
     * 등록 버튼을 누를 시 addContent() 실행
     *
     * @return \Illuminate\Http\Response
     */
    public function addContent(request $request, $num)
    {
        $content_of_works = new ContentOfWork();
        $chapter_of_works = ChapterOfWork::select(
            'chapter_of_works.num_of_work'
        )->where('chapter_of_works.num', '=', $num)->first();

        $num_of_workkk = $chapter_of_works->num_of_work;

        // 현재 작품 번호를 받아온다.
        $content_of_works->num_of_work = $num_of_workkk;
        // 현재 회차 번호를 받아온다.
        $content_of_works->num_of_chapter = $num;
        // 회차 제목 추가
        $content_of_works->subsubtitle = $request->subsubtitle;
        // 회차 내용 디폴트값 넣어주기
        $content_of_works->content = "物語《ものがたり》を書《か》きましょう";
        $content_of_works->save();

        return redirect('editor.main.list' . $num)->with('message', 'success');
    }

    /**
     * 에디터 작성 페이지
     * 필요한 데이터 - 작품 제목, 챕터 제목, 회차 제목, 템플릿, 협업 멤버, 에피소드 목차 
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // works 테이블에서 해당 작품 번호, 작품 타이틀을 받아온다.
        $works = Work::select('works.num', 'works.work_title')->orderBy('works.created_at', 'desc')->get();

        // worklists 테이블에서 해당 작품 번호의 작가 리스트(협업 멤버)를 받아온다.
        $work_lists = WorkList::select('work_lists.user_id')
            ->join('content_of_works', 'work_lists.num_of_work', '=', 'content_of_works.num')
            ->get();

        // template 테이블에서 템플릿 전부 받아온다.
        $templates = Template::select('templates.template')->get();

        // episode 테이블에서 해당 회차의 에피소드 제목을 전부 받아온다.
        //  $episodes = Episode::table('episodes')
        //              ->join('content_of_works','content_of_works.subsubtitle','=','episodes.subsubtitle_of_content')
        //              ->value('episodes.episode_title');       

        // content_of_works 테이블에서 해당 작품 번호의 챕터 제목, 회차 제목을 받아온다.
        $content_of_works = ContentOfWork::select('content_of_works.subtitle_of_chapter', 'content_of_works.subsubtitle')
            ->join('works', 'content_of_works.num_of_work', '=', 'works.num')->get();


        return view('editor.tool.editor')
            ->with('content_of_works', $content_of_works)
            ->with('works', $works)
            ->with('work_lists', $work_lists)
            ->with('templates', $templates);
        // ->with('episodes', $episodes);
    }

    /**
     * 에디터 저장
     * 
     * 테이블에는 글 내용만 저장되면 된다.
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $content_of_works = new ContentOfWork();
        $content_of_works->content = $request->content;
        $content_of_works->$content_of_works->save();

        return view('/')
            ->with('message', $subsubtitle . '이 성공적으로 업로드 되었습니다.');
    }

    /**
     * Display the speied resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    { }

    /**
     * 에디터 수정
     * 
     * 최초 저장 이후 에디터에 접속하는 경우는 전부 에디터 수정이 된다.
     * 필요한 정보 - 작품 제목, 챕터 제목, 회차 제목, 템플릿, 협업 멤버, 에피소드 목차, 글 내용
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($num)
    {
        // 지금 이 num은 회차 번호이다... 회차 번호를 타고 가서 챕터 번호를 따와야 한다... 
        // $content_lists = ContentOfWork::select(
        //     // 얘는 회차 번호
        //     'content_of_works.num',
        //     'content_of_works.subsubtitle',
        //     'content_of_works.created_at',
        //     // 회차의 챕터 번호
        //     'content_of_works.num_of_chapter'
        // )->join('chapter_of_works', 'content_of_works.num_of_chapter', '=', 'chapter_of_works.num')
        //     ->where('content_of_works.num_of_chapter', '=', $num)
        //     ->get();

        $chapter_of_num_of_now_content = ContentOfWork::select(
            'content_of_works.num_of_chapter'
        )->where('content_of_works.num', '=', $num)->first();

        $num_of_now_chapter = $chapter_of_num_of_now_content->num_of_chapter;


        // 상단에 작품 제목이랑 챕터 제목을 띄워주는거.....
        $titles = Work::select(
            'chapter_of_works.subtitle',
            'works.work_title',
            'works.num'
        )->join('chapter_of_works', 'chapter_of_works.num_of_work', '=', 'works.num')
            ->where('chapter_of_works.num', '=', $num_of_now_chapter)->get();

        // 지금 이 num은 회차 번호이다... 회차 번호를 타고 가서 챕터 번호를 따와야 한다... 
        $content_lists = ContentOfWork::select(
            // 얘는 회차 번호
            'content_of_works.num',
            'content_of_works.subsubtitle',
            'content_of_works.created_at',
            // 회차의 챕터 번호
            'content_of_works.num_of_chapter'
        )->join('chapter_of_works', 'content_of_works.num_of_chapter', '=', 'chapter_of_works.num')
            ->where('content_of_works.num_of_chapter', '=', $num_of_now_chapter)
            ->get();

        $content_of_works = ContentOfWork::select('*')->where('num', $num)->first();

        // return $content_lists;
        // return $content_of_works;
        return view('editor/tool/editor')
            ->with('content_of_works', $content_of_works)
            ->with('content_lists', $content_lists)
            ->with('titles', $titles);
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
        $content_of_works = ContentOfWork::where('num', $request->num)->first();


        $content_of_works->content = $request->content;
        $content_of_works->save();

        return view('editor.main.list' . $content_of_works->num_of_chapter);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $content_of_works->delete();

        return redirect()->route('editor.main.list')
            ->with('success',  'Content deleted successfu lly.');
    }

    public function res()
    {
        return view('editor.tool.res');
    }
}
