<?php

namespace App\Http\Controllers\WorkOut;

use App\Models\Work;
use App\Models\User;
use App\Models\PeriodOfWork;
use App\Models\ChapterOfWork;
use App\Models\WorkList;
use App\Models\CategoryWork;
use App\Models\ContentOfWork;
use Auth;
use Illuminate\Support\Facades\Storage;
// use App\Models\ContentOfWork;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    private $work_model = null;
    private $work_list_model = null;
    private $category_model = null;
    private $period_model = null;

    /**
     * 작업방 컨트롤러 입니다. (작업방 보기, 작품 추가, 수정, 삭제 매소드)
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // return $this->middleware('auth');
        $this->work_model = new Work();
        $this->work_list_model = new WorkList();
        $this->category_model = new CategoryWork();
        $this->period_model = new PeriodOfWork();
    }

    /**
     * 작업방에서 보여져아 할 데이터 값
     * 작품번호, 북커버, 제목, 태그, 연재종류, 연재상태, 연재주기, 협업 멤버, 가격(대여,구매), 최근 수정시간
     */
    public function index()
    {

        // $type_query = Work::raw(
        //     "(CASE WHEN 'works.type_of_work'='1'
        //         THEN '단편' 
        //         WHEN 'works.type_of_work'='2'
        //         THEN '단행본'
        //         WHEN 'works.type_of_work'='3' 
        //         THEN '회차' 
        //         ELSE ''
        //         END) as name");

        // $works = Work::select($type_query)->get();
        // return $works;

        $works = Work::select(
            // 작품번호
            'works.num',
            // 제목
            'works.work_title',
            // 연재종류
            'works.type_of_work',
            // 대여 가격
            'works.rental_price',
            // 구매 가격
            'works.buy_price',
            // 연재상태
            'works.status_of_work',
            // 북커버
            'works.bookcover_of_work',
            // 연재주기
            // 'period_of_works.cycle_of_publish'
            // 태그
            'category_works.tag'
        )->join('category_works', 'category_works.num_of_work', '=', 'works.num')
            ->join('work_lists', 'work_lists.num_of_work', '=', 'works.num')
            // 현재 로그인 한 사용자가 참여하고 있는 작품만 보여지게
            ->whereIn('works.num', function ($query) {
                $query->select('work_lists.num_of_work')->where('work_lists.user_id', '=', \Auth::user()['id']);// 최신순 정렬
            })->orderBy('works.created_at', 'desc')->get();

        // 최근 수정 시간
        $modify_time = ContentOfWork::select(
            'content_of_works.updated_at'
        )
        ->join('works','content_of_works.num_of_work','=','works.num')
        ->orderBy('updated_at', 'desc')->first();
        $nicknames = User::select(
            'users.nickname'
        )
        ->join('work_lists','work_lists.user_id','=','users.id')
        ->whereIn('work_lists.num_of_work',function($query){
            $query->select('num')->from('works')->where('works.num',1);
        })->get();

        // return $nicknames;

        // return $nicknames;

        // ->whereIn('users.id', '=', function($query){
        //     $query->select('user_id')->from('work_lists')->whereIn('num_of_works','=',1);
        // })->get();

        // return $nicknames;
        return view('index')->with('works', $works)->with('modify_time',$modify_time)->with('nicknames',$nicknames);
    }

    /**
     * 작품 추가
     * 
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

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
        Auth::user()['roles'] === 2 ? $role = "Author" : $role = "Illustrator";

        $this->validate($request, [                     # |mimes:jpeg,png,jpg,gif,svg
            'image' => 'required|image|max:16384',      # image파일만 + 16MB까지
        ]);
        $bookName = $request->work_title;
        $userEmail = Auth::user()['email'];

        $staticPath = "WorkSpace/";
        $staticFolder = "/OPS" . '/' . "images/";
        $s3Path = $staticPath . $bookName . $staticFolder;

        $filePath = $role . '/' . $userEmail . '/' . $s3Path;

        $bookCoverUrl ="https://s3.ap-northeast-2.amazonaws.com/lanovebucket/".$filePath;

        if ($request->hasFile('image')) {                                       #1 image 파일이 있으면
            if (!Storage::disk('s3')->exists($filePath)) {                      #2 폴더가 있으면 ture 없으면 fasle, 없으면 하위 디렉토리까지 싹 만들어줌
                Storage::disk('s3')->makeDirectory($filePath);                  #3 폴더가 없으면 해당 경로에 폴더를 만들어 줌 $filePath에 / 기준으로 폴더가 생성됨
            }
            $file = $request->file('image');                                    #4 Request로 부터 불러온 정보를 변수에 저장 
            $name = time() . $file->getClientOriginalName();                    #5 파일명이 겹칠 수 있으니 시간 + 원본명으로 저장
            $saveFilePath = $filePath . $name;                                  #6 저장 파일 경로 = 폴더 경로 + 파일 이름
            Storage::disk('s3')->put($saveFilePath, file_get_contents($file), [ #7 설정한 경로로 파일 저장 + 전체파일을 문자열로 읽어들이는 PHP 함수
                'visibility' => 'public',
                'Metadata' => ['Content-Type' => 'image/jpeg'],
            ]);

                    // 작품 저장
        $work_info = array([
            // 제목
            'work_title' => $request->get('work_title'),
            // 연재종류
            'type_of_work' => $request->get('radio_T'),
            // 대여 및 구매 가격
            'rental_price' => $request->get('rental_price'),
            'buy_price' => $request->get('buy_price'),
            // 조회수 (default = 0)
            'hits_of_work' => 0,
            // 작품 소개
            'introduction_of_work' => $request->get('introduction_of_work'),
            // 북커버 (파일명)
            'bookcover_of_work' => $bookCoverUrl.$name,
            // 연재 상태 (default = 1 (연재중))
            'status_of_work' => 1,
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
            'user_id' => \Auth::user()['id']
        ]);
        $this->work_list_model->storeWorklist($work_list_info);

        return redirect('/')->with('message', "success");
        
        } else {
            echo "<script> alert('파일이 존재하지 않습니다.') <script/>";
            return redirect('addBook');
        }


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
            ->with('works', $works)->with( 'num', $num);
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
        
        $result = array(
            "subtitle" => $request->subtitle,
            "num" => $num
        );

        echo "<script>opener.parent.location.reload();
                      window.close()</script>";
        // return response()->json($result, 200);
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

    public function setBookCover(Request $request)
    {
        Auth::user()['roles'] === 2 ? $role = "Author" : $role = "Illustrator";

        $this->validate($request, [                     # |mimes:jpeg,png,jpg,gif,svg
            'image' => 'required|image|max:16384',      # image파일만 + 16MB까지
        ]);
        // $workSpaceNum = $request->roolnum;

        $bookName = $request->work_title;

        $userEmail = Auth::user()['email'];

        $staticPath = "WorkSpace/";
        $staticFolder = "/OPS" . '/' . "images/";
        $s3Path = $staticPath . $bookName . $staticFolder;

        $filePath = $role . '/' . $userEmail . '/' . $s3Path;

        if ($request->hasFile('image')) {                                #1 image 파일이 있으면
            if (!Storage::disk('s3')->exists($filePath)) {               #2 폴더가 있으면 ture 없으면 fasle, 없으면 하위 디렉토리까지 싹 만들어줌
                Storage::disk('s3')->makeDirectory($filePath);           #3 폴더가 없으면 해당 경로에 폴더를 만들어 줌 $filePath에 / 기준으로 폴더가 생성됨
            }
            $file = $request->file('image');                             #4 Request로 부터 불러온 정보를 변수에 저장 
            $name = time() . $file->getClientOriginalName();             #5 파일명이 겹칠 수 있으니 시간 + 원본명으로 저장
            $saveFilePath = $filePath . $name;                           #6 저장 파일 경로 = 폴더 경로 + 파일 이름
            Storage::disk('s3')->put($saveFilePath, file_get_contents($file), [ #7 설정한 경로로 파일 저장 + 전체파일을 문자열로 읽어들이는 PHP 함수
                'visibility' => 'public',
                'Metadata' => ['Content-Type' => 'image/jpeg'],
                'Expires' => Carbon::now()->addMinute(5),                #7 expire 현재시간 + 5분 적용 외않되
            ]);

            return back()->withSuccess('Image uploaded successfully');   #8 성공했을 시 이전 화면으로 복귀 (이후 ajax처리 해야할 부분)
        } else {
            echo "<script> alert('파일이 존재하지 않습니다.') <script/>";
            return redirect('/');
        }
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

 