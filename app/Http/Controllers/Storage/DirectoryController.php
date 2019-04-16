<?php

namespace App\Http\Controllers\Storage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Http\Controllers\tools;
use App\Models\WorkList;
use Auth;

class DirectoryController extends Controller
{
    private $tools = null;
    public function __construct()
    {
        $this->tools = new tools();
        $this->middleware('auth');   # 인증된 사용자만 이용할 수 있게 , route(login)이 실행됨.
    }



    # @return \Illuminate\Http\Response
    # Display a listing of the resource.
    public function index(Request $request)                        # get Directories & get Files
    {
        /* 접근 폴더 주소 만들기
        *  폴더 종류 : public(작품 내에 존재하는 공동작업방), private(작가와 일러스트레이터 개인 저장공간)
        *
        */
        $publicPath = "images/"; # return $this->tools->getPublicS3Path($publicPath); !!!!!!!!!!!!!!!!!!!!!
        Auth::user()['roles'] === 2 ? $role = "Author" : $role = "Illustrator";   //2면 Author/ else Illustrator/

        $privateFolder = Storage::disk('s3')->directories($role . DIRECTORY_SEPARATOR . Auth::user()['email']);    # 접속한 유저의 개인 폴더
        $privateFiles = Storage::disk('s3')->files($role . DIRECTORY_SEPARATOR . Auth::user()['email'] . DIRECTORY_SEPARATOR . 'images');
        $privateFile = [];
        foreach ($privateFiles as $file) {
            $privateFile[] = [
                'name' => str_replace($role . DIRECTORY_SEPARATOR . Auth::user()['email'] . DIRECTORY_SEPARATOR . config('filesystems.disks.s3.image'), '', $file), # issue : 삭제 안되던 것 name att 추가한 뒤로 정상 작동 $file에서 경로명 다 ''로 지우고 파일명만 등록
                'size' => file_size(Storage::disk('s3')->size($file)),                          # file 하나하나 접근해서 size를 가져옴
                'path' => $file,                                                                # $file 문자열에서 images/를 ''로 치환함 어디서 쓸 수 있을까?
                'src' => config('filesystems.disks.s3.url') . $file,                            # img src에서 접근할 수 있는 파일 주소
                'updated_at' => date("Y-m-d h:i:s", Storage::disk('s3')->lastModified($file)),  # 마지막에 파일이 업데이트 되었을 때 타임 스탬프값(unix값) 시간 포맷 https://stackoverflow.com/questions/10040291/converting-a-unix-timestamp-to-formatted-date-string
                'type' => Storage::disk('s3')->getMimeType($file),
            ];
        }

        $dirInfo = WorkList::select('users.email', 'works.num', 'works.work_title')
            ->leftjoin('works', 'work_lists.num_of_work', '=', 'works.num')
            ->leftjoin('users', 'work_lists.num_of_work', '=', 'works.num')
            ->where('work_lists.num_of_work', '=', 1) //$num   // 숫자 부분은 변수로 전달 받아야함
            ->orderBy('work_lists.created_at', 'asc')
            ->limit(1)->get();

        // 작가와 일러스트레이터가 함께 사용할 폴더 : Author/작가ID/WorkSpace/작품이름/OBPES/images
        $staticAuthor = $dirInfo[0]['email'];       //test@test
        $staticTitle = $dirInfo[0]['work_title'];   //류vs김
        $staticFullPath = 'Author' . DIRECTORY_SEPARATOR . $staticAuthor . DIRECTORY_SEPARATOR . 'WorkSpace' . DIRECTORY_SEPARATOR . $staticTitle . DIRECTORY_SEPARATOR . 'OEBPS';
        # author/test@test/WorkSpace/류vs김/OEBPS/images

        $publicFolder = Storage::disk('s3')->directories($staticFullPath);    # 접속한 유저의 개인 폴더
        $publicFiles = Storage::disk('s3')->files($staticFullPath . DIRECTORY_SEPARATOR . 'images');
        $publicFile = [];
        foreach ($publicFiles as $file) {
            $publicFile[] = [
                'name' => str_replace($role . DIRECTORY_SEPARATOR . Auth::user()['email'] . DIRECTORY_SEPARATOR . config('filesystems.disks.s3.image'), '', $file), # issue : 삭제 안되던 것 name att 추가한 뒤로 정상 작동 $file에서 경로명 다 ''로 지우고 파일명만 등록
                'size' => file_size(Storage::disk('s3')->size($file)),                          # file 하나하나 접근해서 size를 가져옴
                'path' => $file,                                                                # $file 문자열에서 images/를 ''로 치환함 어디서 쓸 수 있을까?
                'src' => config('filesystems.disks.s3.url') . $file,                            # img src에서 접근할 수 있는 파일 주소
                'updated_at' => date("Y-m-d h:i:s", Storage::disk('s3')->lastModified($file)),  # 마지막에 파일이 업데이트 되었을 때 타임 스탬프값(unix값) 시간 포맷 https://stackoverflow.com/questions/10040291/converting-a-unix-timestamp-to-formatted-date-string
                'type' => Storage::disk('s3')->getMimeType($file),
            ];
        }

        #$dirFiles = Storage::disk('s3')->files($path);
        #$dir = Storage::disk('s3')->directories($role);
        #해당 경로에 있는 모든 directory (폴더만)
        #리소스 폴더 보여줌 directories -> 폴더 누름(눌럿을 때 모든 파일+폴더 보임) allfile + directories -> file 또는 directory 들어감
        #리소스 폴더 생성

        $inDirectory = [    // 폴더 접근 url + 파일 info
            'directories' => [
                'PRIVATE_FOLDER' => $privateFolder,
                'PUBLIC_FOLDER' => $publicFolder
            ],
            'files' => [
                'PRIVATE_FILE' => $privateFile,
                'PUBLIC_FILE' => $publicFile
            ]
        ];

        // 'metadata' => Storage::disk('s3')->getMetadata($file) / 모든 메타데이터 가져옴
        return response()->json($inDirectory, 200, [], JSON_PRETTY_PRINT); //어떤값이 오는지 확인
        return $inDirectory['directories'];

        if ($privateFolder === []) {  // 해당 폴더에 더이상 폴더가 없으면?
            $dir = Storage::disk('s3')->allFiles($role);
        }
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
