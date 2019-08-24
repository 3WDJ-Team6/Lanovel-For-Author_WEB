<?php

namespace App\Http\Controllers\WorkOut;

use Auth;
use Carbon\Carbon;

use App\Models\ContentOfWork;
use App\Models\ChapterOfWork;
use App\Models\Work;
use App\Models\WorkList;
use App\Models\Template;
use App\Models\Memo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\CommentOfWork;
use App\Models\Grade;
use App\Events\ShareEvent;
use Illuminate\Support\Facades\Redis;

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
        /**,
         * 인증 된 사용자만 목차 리스트 및 에디터에 접근할 수 있다.
         */
        // return $this->middleware('auth');
    }
    /** 목차 리스트 보기
     * 필요한 데이터 - 챕터 제목(or 권수), 회차 제목(or 회차수) 작품 생성 시각, 작품 최종 수정 시각,
     */

    public function index($num)
    {
        $nowChapter = ChapterOfWork::select(
            'chapter_of_works.*'
        )->where('chapter_of_works.num', '=', $num)
            ->first();

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

        return view('editor.main.list')
            ->with('chapter_of_works', $chapter_of_works)->with('num', $num)->with('nowChapter', $nowChapter);
    }

    // public function store_memo(Request $request, $num)
    // {
    //     $memos = new Memo();

    //     $memos->content_of_work = $request->num;
    //     $memos->user_id = Auth::user()['id'];
    //     $memos->content_of_memo = $request->content_of_memo;

    //     // 메모 저장
    //     $memos->save();

    //     return "메모 저장됨";
    // }

    public function content_create($num)
    {

        return view('editor.main.popup')->with('num', $num);
    }

    public function content_create_in_editor($num)
    {
        return view('editor.tool.popup_in_editor')->with('num', $num);
    }

    public function content_edit($num)
    {
        $content_data = ContentOfWork::select(
            'content_of_works.num',
            'content_of_works.subsubtitle'
        )->where('content_of_works.num', '=', $num)->first();

        return view('editor.main.popup_edit')->with('content_data', $content_data);
    }

    public function content_edit_in_editor($num)
    {
        $content_data = ContentOfWork::select(
            'content_of_works.num',
            'content_of_works.subsubtitle'
        )->where('content_of_works.num', '=', $num)->first();

        return view('editor.tool.popup_in_editor_edit')->with('content_data', $content_data);
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
        $chapNum = $chapter_of_works;
        // 현재 회차 번호를 받아온다.
        $content_of_works->num_of_chapter = $num;
        // 회차 제목 추가
        $content_of_works->subsubtitle = $request->subsubtitle;
        // 회차 내용 디폴트값 넣어주기
        $content_of_works->content = "<p class='text_p' tabindex='-1'>物語《ものがたり》を書《か》きましょう</p>";
        $content_of_works->save();

        echo "<script>opener.parent.location.reload();window.close()</script>";
    }

    public function addContentInEditor(request $request, $num)
    {
        // 에디터 내에서 작품 추가하기
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
        ///////숫자값만 넘어가던 오류를
        ///////$subsubtitle에 회차 제목값 넣고
        $subsubtitle = $request->subsubtitle;
        ///////$subsubtitle의 값을 디비 $content_of_works의 subsubtitle에 넣고
        $content_of_works->subsubtitle = $subsubtitle;
        // 회차 내용 디폴트값 넣어주기
        $content_of_works->content = "<p class='text_p' tabindex='-1'>物語《ものがたり》を書《か》きましょう</p>";
        $content_of_works->save();
        $titleNum = $content_of_works->num;
        ///////부모창의 addEpisode()함수에 '$subsubtitle' 값 전달
        // return $titleNum;
        echo "<script>window.close();window.opener.parent.addEpisode('$subsubtitle' ,$titleNum);</script>";
    }

    public function editContent(request $request, $num)
    {
        $content_of_works = ContentOfWork::where('num', $request->num)->first();
        $content_of_works->subsubtitle = $request->subsubtitle;
        $content_of_works->save();

        echo "<script>self.close();window.opener.parent.location.reload();</script>";
        // return back();
    }

    public function editContentInEditor(request $request, $num)
    {
        $content_of_works = ContentOfWork::where('num', $request->num)->first();
        $originTitle = $content_of_works->subsubtitle;
        $changeTitle = $request->subsubtitle;
        $content_of_works->subsubtitle = $changeTitle;
        $content_of_works->save();
        echo "<script>window.close();window.opener.parent.editEpisode('$changeTitle', '$originTitle');</script>";
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
        return $request;
        $content_of_works = new ContentOfWork();
        $content_of_works->content = $request->content;
        $content_of_works->$content_of_works->save();

        return view('/');
    }

    /**
     * Display the speied resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $nickname = null, $num = null)
    {
        if($nickname = null || $num = null){
            return 0;
        }else{
        # 화면공유 로직
        $content = $request->content;
        broadcast(new \App\Events\ShareEvent($nickname, $num, $content));
        return 0;
    }
    }

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
        // broadcast(new \App\Events\ShareEvent());
        // $redis = Redis::connection('share-event');
        // $redis->publish('share-event', 'temp');
        // $temp = Redis::get('num' . $num);
        // Redis::set('name', 'test');
        // $values = Redis::command('lrange', ['name', 5, 10]);

        $work_of_num_of_now_content = ContentOfWork::select(
            'content_of_works.num_of_work'
        )->where('content_of_works.num','=',$num)->first();

        $num_of_now_work = $work_of_num_of_now_content->num_of_work;

        $chapter_of_num_of_now_content = ContentOfWork::select(
            'content_of_works.num_of_chapter'
        )->where('content_of_works.num', '=', $num)->first();

        $num_of_now_chapter = $chapter_of_num_of_now_content->num_of_chapter;

        // 메모 있으면 보여주기

        $memos = Memo::select(
            '*'
        )->where('memos.num_of_content', '=', $num)
            ->get();

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

        $memberlist = WorkList::select(
            // 'work_lists.user_id'
            'users.nickname',
            'users.profile_photo'
        )->join('users', 'users.id', 'work_lists.user_id')
        ->where('work_lists.num_of_work','=',$num_of_now_work)->get();

        // return $content_of_works['content'];
        // return $content_lists;
        return view('editor/tool/editor')
            ->with('content_of_works', $content_of_works)
            ->with('content_lists', $content_lists)
            ->with('titles', $titles)
            ->with('memos', $memos)
            ->with('user', Auth::user()['nickname'])
            ->with('memberlist',$memberlist);
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
        $editor_content = $request->content;
        // return $editor_content;

        $content_of_works = ContentOfWork::where('num', $request->num)->first();
        // return $request->editor_content;
        $count = 0;
        $imglist = [];
        $ttext = $editor_content;
        while (1) {
            if (str::contains($editor_content, 'height: auto;">')) {
                $editor_content = str::replaceFirst('height: auto;">', 'height: auto;" />', $editor_content);
            } elseif (str::contains($editor_content, 'height:auto;">')) {
                $editor_content = str::replaceFirst('height:auto;">', 'height: auto;" />', $editor_content);
            } elseif (preg_match('/servername="[!-z0-9]*\.[!-z0-9]{3,4}"/', $editor_content)) {
                $editor_content = preg_replace('/servername="[!-z0-9]*\.[!-z0-9]{3,4}"/', "" , $editor_content);
            } elseif (str::contains($editor_content, 'div')) {
                $editor_content = str::replaceFirst('div', 'span', $editor_content);
            } elseif (str::contains($editor_content, '&nbsp;')) {
                $editor_content = str::replaceFirst('&nbsp;', '', $editor_content);
            } elseif (str::contains($editor_content, 'resize">')) {
                $editor_content = str::replaceFirst('resize">', 'resize" />', $editor_content);
            } elseif (str::contains($editor_content, '<br>')) {
                $editor_content = str::replaceFirst('<br>', '<br />', $editor_content);
            } elseif (str::contains($editor_content, '></video>')) {
                $editor_content = str::replaceFirst('></video>', '/>', $editor_content);
            } elseif (str::contains($editor_content, 'src="/images/tool_icon/speaker_icon.png" alt="alt"')) {
                $editor_content = str::replaceFirst('src="/images/tool_icon/speaker_icon.png" alt="alt"', 'src="../images/tool_icon/speaker_icon.png" alt="alt"', $editor_content);
            } elseif (str::contains($editor_content, 'onclick="audioPlay(event)">')) {
                $editor_content = str::replaceFirst('onclick="audioPlay(event)">', 'onclick="audioPlay(event)" />', $editor_content);
            } else {
                break;
            }
        }
        $content_of_works->content = $editor_content;
        $content_of_works->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $content_of_works->delete();

        return redirect()->route('editor.main.list')
            ->with('success',  'Content deleted successfu lly.');
    }
    public function res(Request $request)
    {
        return view('editor.tool.res2');
    }


    // public function res(Request $request)
    // {
    //     $url = 'https://s3.ap-northeast-2.amazonaws.com/lanovebucket/index.html?prefix=Author/';
    //     return response()->json($url, 200);
    // }

    public function send(Request $request)
    {
        return $request;
    }

    public function store_memo(Request $request, $num_of_content, $num)
    {
        // return $num_of_content;
        $memos = new Memo();

        $memos->num_of_content = $num_of_content;
        $memos->user_id = Auth::user()['id'];
        $memos->content_of_memo = $request->content_of_memo;

        // 메모 저장
        $memos->save();
    }
}
