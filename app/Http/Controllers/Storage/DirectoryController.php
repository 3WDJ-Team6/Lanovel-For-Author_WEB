<?php

namespace App\Http\Controllers\Storage;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Traits\FileTrait;
use App\Models\Work;

class DirectoryController extends Controller
{
    use FileTrait;
    public function __construct()
    {
        # $this->tools = new tools();
        $this->middleware('auth');
    }



    # @return \Illuminate\Http\Response
    # Display a listing of the resource.
    public function index(Request $request,  $bookNum, $dir = null, $folderName = null)                        # get Directories & get Files
    {
        /* 접근 폴더 주소 만들기
        *  폴더 종류 : public(작품 내에 존재하는 공동작업방), private(작가와 일러스트레이터 개인 저장공간)
        *
        */
        Auth::user()['roles'] === 2 ? $role = "Author" : $role = "Illustrator";   //2면 Author/ else Illustrator/

        $privateFolder = Storage::disk('s3')->directories($role . DIRECTORY_SEPARATOR . Auth::user()['email']);    # 접속한 유저의 개인 폴더
        $privateFiles = Storage::disk('s3')->files($role . DIRECTORY_SEPARATOR . Auth::user()['email'] . DIRECTORY_SEPARATOR . $folderName);
        $privateFile = [];
        foreach ($privateFiles as $file) {
            $privateFile[] = [
                'name' => substr(str_replace($role . '/' . Auth::user()['email'] . '/' . $folderName . '/', '', $file), 10),                              # issue : 삭제 안되던 것 name att 추가한 뒤로 정상 작동 $file에서 경로명 다 ''로 지우고 파일명만 등록
                'fileName' => str_replace($role . '/' . Auth::user()['email'] . '/' . $folderName . '/', '', $file),
                #'size' => file_size(Storage::disk('s3')->size($file)),                          # file 하나하나 접근해서 size를 가져옴
                'path' => $file,                                                                 # $file 문자열에서 images/를 ''로 치환함 어디서 쓸 수 있을까?
                'src' => config('filesystems.disks.s3.url') . $file,                             # img src에서 접근할 수 있는 파일 주소
                #'updated_at' => date("Y-m-d h:i:s", Storage::disk('s3')->lastModified($file)),  # 마지막에 파일이 업데이트 되었을 때 타임 스탬프값(unix값) 시간 포맷 https://stackoverflow.com/questions/10040291/converting-a-unix-timestamp-to-formatted-date-string
                #'type' => Storage::disk('s3')->getMimeType($file),
            ];
        }

        $bookInfo = Work::select('users.email', 'works.num', 'works.work_title')
            ->leftjoin('work_lists', 'works.num', 'work_lists.num_of_work')
            ->leftjoin('users', 'work_lists.user_id', 'users.id')
            ->where('works.num', '=', $bookNum)            //$num 숫자 부분은 변수로 전달 받아야함
            ->orderBy('work_lists.created_at', 'asc')
            ->first();  // 21번 작품을 쓴 작가 email = Author@test, bookTitle

        // 작가와 일러스트레이터가 함께 사용할 폴더 : Author/작가ID/WorkSpace/작품이름/OBPES/images

        $staticFullPath = 'Author' . DIRECTORY_SEPARATOR . $bookInfo['email'] . DIRECTORY_SEPARATOR . 'WorkSpace' . DIRECTORY_SEPARATOR . $bookInfo['work_title'] . DIRECTORY_SEPARATOR . 'OEBPS';

        $publicFolder = Storage::disk('s3')->directories($staticFullPath);    # 접속한 유저의 개인 폴더
        $publicFiles = Storage::disk('s3')->files($staticFullPath . DIRECTORY_SEPARATOR . 'images');
        $publicFile = [];
        foreach ($publicFiles as $file) {
            $publicFile[] = [
                'name' => substr(str_replace('Author' . '/' . $bookInfo['email'] . '/' .
                    'WorkSpace' . '/' . $bookInfo['work_title'] . '/' . 'OEBPS' . '/' . config('filesystems.disks.s3.images') . '/', '', $file), 10), # issue : 삭제 안되던 것 name att 추가한 뒤로 정상 작동 $file에서 경로명 다 ''로 지우고 파일명만 등록
                'fileName' => str_replace('Author' . '/' . $bookInfo['email'] . '/' .
                    'WorkSpace' . '/' . $bookInfo['work_title'] . '/' . 'OEBPS' . '/' . config('filesystems.disks.s3.images') . '/', '', $file),
                #'size' => file_size(Storage::disk('s3')->size($file)),                         # file 하나하나 접근해서 size를 가져옴
                'path' => $file,                                                                # $file 문자열에서 images/를 ''로 치환함 어디서 쓸 수 있을까?
                'src' => config('filesystems.disks.s3.url') . $file,                            # img src에서 접근할 수 있는 파일 주소
                #'updated_at' => date("Y-m-d h:i:s", Storage::disk('s3')->lastModified($file)), # 마지막에 파일이 업데이트 되었을 때 타임 스탬프값(unix값) 시간 포맷 https://stackoverflow.com/questions/10040291/converting-a-unix-timestamp-to-formatted-date-string
                #'type' => Storage::disk('s3')->getMimeType($file),
            ];
        }

        #$dirFiles = Storage::disk('s3')->files($path);
        #$dir = Storage::disk('s3')->directories($role);  #해당 경로에 있는 모든 directory (폴더만)
        #리소스 폴더 보여줌 directories -> 폴더 누름(눌렀을 때 모든 파일+폴더 보임) allfile + directories -> file 또는 directory 들어감
        #리소스 폴더 생성

        $rootDirectory = [    // 폴더 접근 url + 파일 info

            'ROOT_DIRECTORIES' => [
                'PRIVATE_FOLDERS' => 'private',
                'PUBLIC_FOLDERS' => 'public'
            ],
            // 'directories' => [
            //     'PRIVATE_FOLDER' => $privateFolder,
            //     'PUBLIC_FOLDER' => $publicFolder,
            // ],
            'PRIVATE_FOLDER' => $privateFolder,
            'PUBLIC_FOLDER' => $publicFolder,

            'PRIVATE_FILE' => $privateFile, # private는 폴더가 계속 늘어나고 줄어드니 변할 수 있어야 함.
            'PUBLIC_FILE' => $publicFile,   # public은 image 하나만 이어도 상관없지만
        ];

        // return response()->json($rootDirectory, 200, [], JSON_PRETTY_PRINT);

        switch ($dir) {
            case 'private':
                $dir = 'PRIVATE_FOLDER';
                break;
            case 'public':
                $dir = 'PUBLIC_FOLDER';
                break;
            case 'root':
                $dir = 'directories';
                break;
            case 'privateFiles':
                $dir = 'PRIVATE_FILE';
                break;
            case 'publicFiles':
                $dir = 'PUBLIC_FILE';
                break;
            default:
                $dir = 'ROOT_DIRECTORIES';
                break;
        }

        // return response()->json($rootDirectory[$dir], 200);
        return response()->json($rootDirectory[$dir], 200, [], JSON_PRETTY_PRINT);

        // 'metadata' => Storage::disk('s3')->getMetadata($file) / 모든 메타데이터 가져옴

        if ($privateFolder === []) {  // 해당 폴더에 더이상 폴더가 없으면?
            $dir = Storage::disk('s3')->allFiles($role);
        }
    }

    # make New Directory
    public function create($dirName)
    {
        //
    }

    # destroy Image or Directory
    public function destroy($id)
    {
        //
    }

    # save Images
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
    # rename Dir Or Files
    public function update(Request $request, $id)
    {
        //
    }

    # Remove the specified resource from storage.
    # @param  int  $id
    # @return \Illuminate\Http\Response

}
