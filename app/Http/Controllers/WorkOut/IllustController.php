<?php

namespace App\Http\Controllers\WorkOut;

use App\Models\IllustrationList;
use App\Models\CategoryIllustration;
use App\Models\BuyerOfIllustration;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IllustController extends Controller
{
    private $illustration_model = null;
    private $category_illust_model = null;

    public function __construct()
    {
        // return $this->middleware('auth');
        $this->illustration_model = new IllustrationList();
        $this->category_illust_model = new CategoryIllustration();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = IllustrationList::select(
            // 작품번호
            'illustration_lists.*',
            'users.nickname'
        )->join('users', 'users.id', 'illustration_lists.user_id')
            ->orderByRaw('illustration_lists.hits_of_illustration', 'desc')
            ->limit(5)
            ->get();

        return view('/store/home/home')->with('products', $products);
    }

    // 대메뉴 구별 (background | character | object)
    public function menuIndex($category)
    {
        $products = IllustrationList::select(
            // 작품번호
            'illustration_lists.*',
            'users.nickname'
        )->join('users', 'users.id', 'illustration_lists.user_id')
            ->join('category_illustrations', 'category_illustrations.num_of_illustration', 'illustration_lists.num')
            ->where('category_illustrations.tag', $category)
            ->get();

        return view('.store.menu.contents')->with('products', $products);
    }

    // 세부 메뉴 구별
    public function detailMenuIndex($category, $moreCategory)
    {
        $products = IllustrationList::select(
            // 작품번호
            'illustration_lists.*',
            'users.nickname'
        )->join('users', 'users.id', 'illustration_lists.user_id')
            ->join('category_illustrations', 'category_illustrations.num_of_illustration', 'illustration_lists.num')
            ->where('category_illustrations.tag', $category)
            ->where('category_illustrations.moreTag', $moreCategory)
            ->get();

        return view('.store.menu.contents')->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('store/menu/upload');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return "라우트 설정은 끝";
        Auth::user()['roles'] === 2 ? $role = "Author" : $role = "Illustrator";

        $illustName = $request->illustration_title;

        # 역할/유저id/WorkSpace/책이름/OEBPS/images/ - 에디터 사용 사진 들어갈 경로
        $s3Path = config('filesystems.disks.s3.workspace') . DIRECTORY_SEPARATOR . $illustName . $this::S3['opsImage'];

        $publicFolder = $role . DIRECTORY_SEPARATOR . Auth::user()['email'] . DIRECTORY_SEPARATOR . config('filesystems.disks.s3.images');  # 역할/유저id/image
        $filePath = $role . DIRECTORY_SEPARATOR . Auth::user()['email'] . DIRECTORY_SEPARATOR . $s3Path;
        $illustrUrl = config('filesystems.disks.s3.url') . $filePath;

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

            // 일러스트 저장
            $illust_info = array([
                // 일러스트 제목
                'illustration_title' => $request->get('illustration_title'),
                // 일러스트레이터 = 현재 로그인 한 사용자
                'user_id' => Auth::user()['id'],
                /** 일러스트 가격
                 * 만약 무료인 경우 price_of_illustration == null 들어가게
                 */
                'price_of_illustration' => $request->get('price_of_illustration'),
                // 조회수 (default = 0)
                'hits_of_illustration' => 0,
                // 시리즈 여부
                'is_series' => $request->get('is_series'),
                // 이 컬럼,, 과연 필요한가.....
                'num_of_series' => 1,
                // 일러스트 소개
                'introduction_of_illustration' => $request->get('introduction_of_illustration'),
                // 북커버 (파일명)
                'position_of_illustration' => $illustrUrl . $name,
                // 대구분
                'division_of_illustration' => $request->get('division_of_illustration'),
                // 생성 날짜 (현재)
                'created_at' => Carbon::now()
            ]);
            // 일러스트 저장
            $this->illustration_model->storeIllust($illust_info);

            // 가장 최근에 저장된 일러스트 불러와서
            $recentIllust = IllustrationList::select(
                'illustration_lists.num',
                'illustration_lists.division_of_illustration'
            )->orderBy('created_at', 'DESC')
                ->first()['num'];


            $illust_tag_info = array([
                'num_of_illustration' => $recentIllust->num,
                'tag' => $recentIllust->division_of_illustration,
                'moreTag' => $request->get('moreTag')
            ]);

            // 태그 저장
            $this->category_illust_model->storeTag($illust_tag_info);

            return redirect('/store')->with('message', "success");
        }
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
