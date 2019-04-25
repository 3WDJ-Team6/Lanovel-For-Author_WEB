<?php

namespace App\Http\Controllers\WorkOut;

use Auth;
use App\Models\IllustrationList;

use App\Models\Work;
use App\Models\WorkList;
use App\Models\RecommendOfWork;
use App\Models\Grade;
use App\Models\CategoryIllustration;
use App\Models\IllustFile;
use App\Models\BuyerOfIllustration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\FilePost;
use App\Traits\FileTrait;

class IllustController extends Controller
{
    use FileTrait;

    private $illustration_model = null;
    private $illust_file_model = null;
    private $category_illust_model = null;

    public function __construct()
    {
        // return $this->middleware('auth');
        $this->illustration_model = new IllustrationList();
        $this->illust_file_model = new IllustFile();
        $this->category_illust_model = new CategoryIllustration();
    }

    public function illustUpload(FilePost $request)
    {
        $attachments = null;
        $filePath = $this->checkUserMakePath();
        $this->hasFile($request, $filePath);

        $file = $request->file('image');
        $saveFileName = time() . $file->getClientOriginalName();
        $saveFilePath = $filePath . $saveFileName;
        $illustFileUrl = config('filesystems.disks.s3.url') . $saveFilePath;
        Storage::disk('s3')->put($saveFilePath, file_get_contents($file), [
            'visibility' => 'public',
            'Metadata' => ['Content-Type' => 'image/jpeg'],
        ]);
        $illust_file_info = [
            'url_of_illustration' => $illustFileUrl,
            'name_of_illustration' => $file->getClientOriginalName(),
            'savename_of_illustration' => $saveFileName,
            'folderPath' => 'Illustrator' . DIRECTORY_SEPARATOR . Auth::user()['email'] . DIRECTORY_SEPARATOR . config('filesystems.disks.s3.images') . DIRECTORY_SEPARATOR,
            'created_at' => Carbon::now()
        ];
        $attachments = IllustFile::create($illust_file_info);  //file을 비동기방식으로 업로드 한 뒤

        return response()->json($attachments, 200);  //업로드 된 파일의 정보를 front에 전달

    }

    public function fileDelete(Request $request, $id)
    {
        $attachments = IllustFile::find($id);
        return $attachments;
        $folderPath = $attachments->folderPath;
        $fileName = $attachments->savename_of_illustration;
        Storage::disk('s3')->delete($folderPath . $fileName);
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

        // $best = IllustrationList::selece(
        //     'i'
        // )

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
            ->where('illustration_lists.division_of_illustration', $category)
            ->orderByRaw('illustration_lists.hits_of_illustration', 'desc')
            ->get();

        return view('.store.menu.contents')->with('products', $products);
    }

    // 상세메뉴검색
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
<<<<<<< HEAD
        return $request;
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
=======
        // echo "라우트 성공";
        // 일러스트 저장

        $illust_info = new IllustrationList();
        $illust_info->illustration_title = $request->illustration_title;
        $illust_info->user_id = Auth::user()['id'];
        $illust_info->price_of_illustration = $request->price_of_illustration;
        $illust_info->hits_of_illustration = 0;
        $illust_info->introduction_of_illustration = $request->introduction_of_illustration;
        $illust_info->division_of_illustration = $request->division_of_illustration;
        $illust_info->created_at = Carbon::now();

        $illust_info->save();

        // return response()->json($illust_info, 200, array(), JSON_PRETTY_PRINT);

        // 가장 최근에 저장된 일러스트 불러와서
        $recentIllust = IllustrationList::select(
            'illustration_lists.num',
            'illustration_lists.division_of_illustration'
        )->orderBy('created_at', 'DESC')
            ->first();

        $strExplode = explode(' ', $request->get('moreTag'));
        $strReplace = str_replace("#", "", $strExplode);

        for ($i = 0; $i < count($strReplace); $i++) {
            $illust_tag_info = array([
                'num_of_illustration' => $recentIllust->num,
                'tag' => $recentIllust->division_of_illustration,
                'moreTag' => $strReplace[$i]
>>>>>>> b442f95971aa7b6925a2e235ea17416c22f3ba1f
            ]);
            // 태그 저장
            $this->category_illust_model->storeTag($illust_tag_info);
        }

        \Log::debug(['attachments' => $request->attachments]);
        if ($request->has('attachments')) {
            foreach ($request->attachments as $file) {
                $attach = IllustFile::find($file);
                $attach->illustration_lists()->associate($illust_info);    //belongsTo 관계를 변경 할 때 associate 메소드를 사용할 수 있음, 이 메소드는 자식 모델에 외래 키를 지정함
                $attach->save();
            }
        }

        return redirect('/store')->with('message', "success");
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
