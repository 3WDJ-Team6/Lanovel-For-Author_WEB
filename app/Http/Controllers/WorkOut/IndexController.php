<?php

namespace App\Http\Controllers\WorkOut;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use App\Models\Work;
use App\Models\User;
use App\Models\PeriodOfWork;
use App\Models\ChapterOfWork;
use App\Models\WorkList;
use App\Models\CategoryWork;
use App\Models\ContentOfWork;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
// use App\Models\ContentOfWork;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FilePost;

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
        // $periods = PeriodOfWork::select(
        //     'period_of_works.*'
        // )->join('work_lists', 'work_lists.num_of_work', '=', 'period_of_works.num_of_work')
        //     ->whereIn('period_of_works.num_of_work', function ($query) {
        //         $query->select('work_lists.num_of_work')->where('work_lists.user_id', '=', Auth::user()['id']);
        //     })->get();

        $posts = Work::select(
            // 작품번호
            'works.*',
            'work_lists.user_id'
        )->join('work_lists', 'work_lists.num_of_work', '=', 'works.num')
            ->join('users', 'users.id', '=', 'work_lists.user_id')
            // 현재 로그인 한 사용자가 참여하고 있는 작품만 보여지게
            ->whereIn('works.num', function ($query) {
                $query->select('work_lists.num_of_work')->where('work_lists.user_id', '=', Auth::user()['id']); // 최신순 정렬
            })->orderBy('works.created_at', 'desc')
            ->get();

        $user_lists = WorkList::select(
            'works.num',
            'work_lists.user_id',
            'users.nickname'
        )->join('works', 'works.num', '=', 'work_lists.num_of_work')
            ->join('users', 'users.id', '=', 'work_lists.user_id')
            // 현재 로그인 한 사용자가 참여하고 있는 작품만 보여지게
            // ->where('works.num', 30)
            // ->whereIn('works.num', function ($query) {
            //     $query->select('work_lists.num_of_work')->where('work_lists.user_id', '=', Auth::user()['id']); // 최신순 정렬
            // })
            ->get();

        $modify_time = ContentOfWork::select(
            'content_of_works.num_of_work',
            'content_of_works.updated_at'
        )->get();

        // return response()->json($modify_time, 200, [], JSON_PRETTY_PRINT);


        $tagCount = Work::select(
            'works.num',
            'category_works.tag',
            DB::raw('(select count(category_works.tag) from category_works where category_works.num_of_work = works.num) count')
        )->join('category_works', 'category_works.num_of_work', '=', 'works.num')
            ->join('work_lists', 'work_lists.num_of_work', '=', 'works.num')
            ->whereIn('works.num', function ($query) {
                $query->select('work_lists.num_of_work')->where('work_lists.user_id', '=', Auth::user()['id']); // 최신순 정렬
            })->orderBy('works.created_at', 'desc')
            ->get();


        // return response()->json($count, 200, [], JSON_PRETTY_PRINT);
        $tagCounts = $tagCount->pluck('count', 'num')->all();

        $periodCount = Work::select(
            'works.num',
            'period_of_works.cycle_of_publish',
            DB::raw('(select count(period_of_works.cycle_of_publish) from period_of_works where period_of_works.num_of_work = works.num) count')
        )->join('period_of_works', 'period_of_works.num_of_work', '=', 'works.num')
            ->join('work_lists', 'work_lists.num_of_work', '=', 'works.num')
            ->whereIn('works.num', function ($query) {
                $query->select('work_lists.num_of_work')->where('work_lists.user_id', '=', Auth::user()['id']); // 최신순 정렬
            })->orderBy('works.created_at', 'desc')
            ->get();

        $periodCounts = $periodCount->pluck('count', 'num')->all();

        // foreach ($periodCount as $pe) {
        //     if ($num_value != $pe->num) {
        //         $real = $pe->cycle_of_publish;
        //         echo $pe->num . $real . "   ";
        //         $value = $real;
        //     } else {
        //         echo ',' . $pe->cycle_of_publish . "  ";
        //     }

        //     $num_value = $pe->num;
        // }
        // return  response()->json($user_lists, 200, [], JSON_PRETTY_PRINT);

        // foreach ($work_nums as $work_num) {
        //     echo $work_num;
        // }

        // return response()->json($works, 200, [], JSON_PRETTY_PRINT);

        // $periods = PeriodOfWork::select(
        //     'period_of_works.*'
        // )->join('work_lists', 'work_lists.num_of_work', '=', 'period_of_works.num_of_work')
        //     ->whereIn('period_of_works.num_of_work', function ($query) {
        //         $query->select('work_lists.num_of_work')->where('work_lists.user_id', '=', Auth::user()['id']);
        //     })->get();

        // return $periods;
        // return $works;

        // return response()->json($works, 200, [], JSON_PRETTY_PRINT);

        // $plucked = $works->pluck('num')->all();
        // $posts = Work::with('work_lists', 'category_works', 'period_of_works')->find($plucked);

        // return $posts;

        // return response()->json($posts, 200, array(), JSON_PRETTY_PRINT);

        return view('index')->with('posts', $posts)->with('periodCount', $periodCount)
            ->with('tagCount', $tagCount)->with('user_lists', $user_lists)->with('modify_time', $modify_time);
    }

    /* 필터링 검색 */
    // public function filterBook(){
    //     if(!$typeOfBook = Input::get('typeOfBook')){
    //         $works = Work::all();
    //     }else{
    //         $works = Work::whereIn('typeOfBook',$typeOfBook)->get();
    //     }
    //     return
    // }

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
    public function store(FilePost $request)    //SetBookCover
    {
        Auth::user()['roles'] === 2 ? $role = "Author" : $role = "Illustrator";

        $bookName = $request->work_title;

        // return Work::select('work_title')->whereIn(function ($query) {
        //     $query->select('work_lists.num_of_work')->where('work_lists.user_id', '=', Auth::user()['id']);
        // })->first();

        # 역할/유저id/WorkSpace/책이름/OEBPS/images/ - 에디터 사용 사진 들어갈 경로
        $s3Path = config('filesystems.disks.s3.workspace') . DIRECTORY_SEPARATOR . $bookName . $this::S3['opsImage'];

        $publicFolder = $role . DIRECTORY_SEPARATOR . Auth::user()['email'] . DIRECTORY_SEPARATOR . config('filesystems.disks.s3.images');  # 역할/유저id/image
        $filePath = $role . DIRECTORY_SEPARATOR . Auth::user()['email'] . DIRECTORY_SEPARATOR . $s3Path;
        $bookCoverUrl = config('filesystems.disks.s3.url') . $filePath;

        if ($request->hasFile('image')) {                                       #1 image 파일이 있으면
            if (!Storage::disk('s3')->exists($filePath) && !Storage::disk('s3')->exists($publicFolder)) {  #2 폴더가 있으면 ture 없으면 fasle, 없으면 하위 디렉토리까지 싹 만들어줌
                Storage::disk('s3')->makeDirectory($filePath, 0777, true);                                             #3 폴더가 없으면 해당 경로에 폴더를 만들어 줌 $filePath에 / 기준으로 폴더가 생성됨
                Storage::disk('s3')->makeDirectory($publicFolder, 0777, true);
                // Storage::disk('s3')->makeDirectory($role . '/' . Auth::user()['email'] . $this::AUTHOR['workspace'] . $bookName, 0777, true);
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
                'bookcover_of_work' => $bookCoverUrl . $name,
                // 연재 상태 (default = 1 (연재중))
                'status_of_work' => 1,
                // 생성 날짜 (현재)
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            $this->work_model->storeWork($work_info);

            $recentWork = Work::select('num')->orderBy('created_at', 'DESC')->first();

            // 현재 로그인 한 사용자를 작품 리스트에 추가
            $work_list_info = array([
                'num_of_work' => $recentWork->num,
                'last_time_of_working' => "test",
                'user_id' => Auth::user()['id'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            $this->work_list_model->storeWorklist($work_list_info);


            // dd($myCheckboxes);

            // if (is_array($_POST['cycle_of_work'])) {
            //     foreach ($_POST['cycle_of_work'] as $value) {
            //         echo $value;
            //     }
            // } else {
            //     $value = $_POST['cycle_of_work'];
            // }

            // $strExplode = explode(' ', $request->get('tag'));
            // $strReplace = str_replace("#", "", $strExplode);

            $periods = $request->input('cycle_of_work');
            // 연재 주기 추가
            // $period = new PeriodOfWork();
            // $period->num_of_work = $recentWork->num;

            $num = 0;
            // return $periods;
            foreach ($periods as $value) {
                // echo $num++;
                $period_info = array([
                    'num_of_work' => $recentWork->num,
                    'cycle_of_publish' => $value
                ]);
                $this->period_model->storePeriodWork($period_info);
            }

            // return $period_model;


            $strExplode = explode(' ', $request->get('tag'));
            $strReplace = str_replace("#", "", $strExplode);

            // 태그 저장
            foreach ($strReplace as $value) {
                $work_tag_info = array([
                    'num_of_work' => $recentWork->num,
                    'tag' => $value
                ]);
                $this->category_model->storeTag($work_tag_info);
            }
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

        $result = array(
            "subtitle" => $request->subtitle,
            "num" => $num
        );


        echo "<script>opener.parent.location.reload();
                      window.close()</script>";
        // return response()->json($result, 200);
    }

    /**
     * Display the specified resource.
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
