<?php

namespace App\Http\Controllers\WorkOut;

use Auth;

use App\Models\ContentOfWork;
use App\Models\Work;
use App\Models\WorkList;
use App\Models\Template;
use App\Models\Episode;
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

    public function __construct(){
        /**
         * 인증 된 사용자만 목차 리스트 및 에디터에 접근할 수 있다.
         */
        return $this->middleware('auth');
    }

    public function index()
    {
        /**
         * 목차 리스트 보기
         * 필요한 데이터 - 챕터 제목(or 권수), 회차 제목(or 회차수), 작품 생성 시각, 작품 최종 수정 시각, 
         */
        $content_of_works = ContentOfWork::select('content_of_works.subtitle_of_chapter', 'content_of_works.subsubtitle', 'content_of_works.created_at', 'content_of_works.updated_at');

        return view('editor.main.list')
               ->with('content_of_works', $content_of_works);
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

        // 현재 작품 번호를 받아온다.
        $content_of_works->num_of_work = $num;
        // 회차 제목 추가
        $content_of_works->subsubtitle = $request->subsubtitle;

        $content_of_works->save();
    }

    /**
     * 에디터 작성
     * 필요한 데이터 - 작품 제목, 챕터 제목, 회차 제목, 템플릿, 협업 멤버, 에피소드 목차 
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

         // works 테이블에서 작품번호, 제목을 받아온다.
         $works = Work::select('works.num', 'works.work_title');

         // worklists 테이블에서 해당 작품 번호의 작가 리스트(협업 멤버)를 받아온다.
         $work_lists = WorkList::table('worklists')
                      ->join('content_of_works','worklists.num_of_work','=','content_of_works.num')
                      ->value('user_id');
 
         // template 테이블에서 템플릿 전부 받아온다.
         $templates = Template::table('templates')->get();

         // episode 테이블에서 해당 회차의 에피소드 제목을 전부 받아온다.
         $episodes = Episode::table('episodes')
                     ->join('content_of_works','content_of_works.subsubtitle','=','episodes.subsubtitle_of_content')
                     ->value('episodes.episode_title');       
         
         // content_of_works 테이블에서 해당 작품 번호의 챕터 제목, 회차 제목을 받아온다.
         $content_of_works = ContentOfWork::table('content_of_works')
                             ->join('works','content_of_works.num_of_work','=','works.num')
                             ->value('subtitle_of_chapter','subsubtitle');


        return view('editor.tool.editor')
               ->with('content_of_works', $content_of_works)
               ->with('works', $works)
               ->with('work_lists', $work_lists)
               ->with('templates', $templates)
               ->with('episodes', $episodes);

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
        $content_of_works->content = $request->content;
    
        $content_of_works->save();

        return view('editor.main.list')
                         ->with('message',$subsubtitle.'이 성공적으로 업로드 되었습니다.');
    }

    /**
     * Display the speied resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

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
    public function edit(Request $request, $content_of_works)
    {
        $content_of_works = ContentOfWork::where('num', $request->num)->first();
        $episodes = Episode::where('num', $request->num)->value('episode_title');
        $templates = Template::where('subsubtitle',$content_of_works)->value('episode_title');
        $episodes = Episode::where('subsubtitle',$content_of_works)->value('episode_title');

        $content_of_works->content = $request->content;
        $content_of_works->save();

        
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
        $request->validate([
            'subtitle_of_work' => 'required',
            'chapter_of_work' => 'required',
            'content_of_work' => 'required',
            'created_at' => 'required',
        ]);

        $content_of_works->update($request->all());

        return redirect()->route('editor.main.list')
                         ->with('success','Content updated successfully.');
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
                         ->with('success','Content deleted successfully.');
    }
}
