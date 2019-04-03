<?php

namespace App\Http\Controllers\Storage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Carbon\Carbon;
# https://laracasts.com/discuss/channels/laravel/how-to-get-properties-name-size-type-of-a-file-retrieved-from-storage?page=1
# 컨트롤러 전역함수 만들어서 쓰기 

class FileController extends Controller
{

    public function __construct()
    {
        return $this->middleware('auth');   # 인증된 사용자만 이용할 수 있게 , route(login)이 실행됨.
    }

    public function index()
    {
        
        Auth::user()['roles'] === 2 ? $role = "Author" : $role = "Illustrator";

        $userEmail = Auth::user()['email'];
        $publicPath = 'Public/';

        $url = 'https://s3.' . "ap-northeast-2" . '.amazonaws.com/' . "lanovebucket" . '/'; # 기본 URL 여기서 Author/Illustrator 나뉨
        $files = Storage::disk('s3')->files($role . '/' . $userEmail . '/' . $publicPath);    # 파일 주소를 가르킴 

        // return response()->json($files, 200, [], JSON_PRETTY_PRINT); //어떤값이 오는지 확인
        $images = [];

        foreach ($files as $file) {
            $images[] = [
                'name' => str_replace($role . '/' . $userEmail . '/' . $publicPath, '', $file), # issue : 삭제 안되던 것 name att 추가한 뒤로 정상 작동 $file에서 경로명 다 ''로 지우고 파일명만 등록
                'size' => file_size(Storage::disk('s3')->size($file)),                          # file 하나하나 접근해서 size를 가져옴
                'path' => $file,                                        # $file 문자열에서 images/를 ''로 치환함 어디서 쓸 수 있을까?
                'src' => $url . $file,                                                          # img src에서 접근할 수 있는 파일 주소
                'updated_at' => date("Y-m-d h:i:s", Storage::disk('s3')->lastModified($file)),  # 마지막에 파일이 업데이트 되었을 때 타임 스탬프값(unix값) 시간 포맷 https://stackoverflow.com/questions/10040291/converting-a-unix-timestamp-to-formatted-date-string
                'type' => Storage::disk('s3')->getMimeType($file),
            ];
        }
        // 'metadata' => Storage::disk('s3')->getMetadata($file) / 모든 메타데이터 가져옴
        // return response()->json($images, 200, [], JSON_PRETTY_PRINT);
        return view('uploadAssets/uploadPage', compact('images'));
    }

    public function store(Request $request)                     #0 파일 저장하는 컨트롤러 asset store & editor 사용
    {
        // if (Auth::user()['roles'] === 2) $role = "Author"; // else if (Auth::user()['roles'] === 3) $role = "Illustrator"; // else redirect('/')->with('message', '잘못된 접근 입니다.');
        Auth::user()['roles'] === 2 ? $role = "Author" : $role = "Illustrator";

        $this->validate($request, [                     #|mimes:jpeg,png,jpg,gif,svg
            'image' => 'required|image|max:16384',      # image파일만 + 16MB까지
        ]);
        // $workSpaceNum = $request->roolnum;

        $userEmail = Auth::user()['email'];
        $filePath = $role . '/' . $userEmail . '/' . 'Public/';

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

    public function destroy($image)
    {
        Auth::user()['roles'] === 2 ? $role = "Author" : $role = "Illustrator";
        $userEmail = Auth::user()['email'];
        $filePath = $role . '/' . $userEmail . '/' . 'Public/';

        Storage::disk('s3')->delete($filePath . $image);    //$image = 삭제하려는 이미지명 
        return back()->withSuccess('성공적으로 삭제 되었습니다.');
    }

    public function getDir()
    {
        # 디렉토리 접근할 수 있도록 , # file접근법 path url 등등 aws, php sdk 사용
        Auth::user()['roles'] === 2 ? $role = "Author/" : $role = "Illustrator/";
        $userEmail = Auth::user()['email'] . '/';
        $folder = 'Public/';
        $path = $role . $userEmail . $folder;

        $dirFiles = Storage::disk('s3')->files($path);
        $dir = Storage::disk('s3')->directories($role); #해당 경로에 있는 모든 directory (폴더만)
        #리소스 폴더 보여줌 directories -> 폴더 누름(눌럿을 때 모든 파일+폴더 보임) allfile + directories -> file 또는 directory 들어감
        #리소스 폴더 생성

        $inDirectory[] = [
            ['directories' => $dir],
            ['files' => $dirFiles]
        ];

        return response()->json($inDirectory, 200, [], JSON_PRETTY_PRINT); //어떤값이 오는지 확인
        return $inDirectory;
        if ($dir === []) {  // 해당 폴더에 더이상 폴더가 없으면?
            $dir = Storage::disk('s3')->allFiles($role);
        }
    }

    public function lendBook()
    {
        // Storage::disk('s3')->getDriver()->put('Path', 'test?', ['visibillity' => 'public', 'Expires, GMT date()']);
        return Storage::disk('s3')->get('Author');
    }

    public function setBookCover(Request $request)
    {
        Auth::user()['roles'] === 2 ? $role = "Author" : $role = "Illustrator";

        $this->validate($request, [                     # |mimes:jpeg,png,jpg,gif,svg
            'image' => 'required|image|max:16384',      # image파일만 + 16MB까지
        ]);
        // $workSpaceNum = $request->roolnum;

        $bookName = $request->bookname;

        $userEmail = Auth::user()['email'];

        $staticPath = "WorkSpace/";
        $staticFolder = "/OPS" . '/' . "images/";
        $s3Path = $staticPath . $bookName . $staticFolder;

        $filePath = $role . '/' . $userEmail . '/' . $s3Path;

        if ($request->hasFile('image')) {                                #1 image 파일이 있으면
            if (!Storage::disk('s3')->exists($filePath)) {               #2 폴더가 있으면 ture 없으면 fasle, 없으면 하위 디렉토리까지 싹 만들어줌 Author/email/ops/image싹다
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

    public function functionSet()
    {

        Storage::disk('s3')->directories(); #해당 경로에 있는 모든 directory (폴더만)

        Storage::disk('s3')->allFiles();    #해당 경로에 있는 모든 file (파일만)

        $originurl = 'https://s3.' . "ap-northeast-2" . '.amazonaws.com/' . "lanovebucket" . '/';

        $fileSize = file_size(Storage::disk('s3')->size('images/' . $imageName));

        $naming = time() . $file->getClientOriginalName(); # 시간 + 원본명으로 저장

        //$request->hasFile('image');                        # image 파일이 있으면

        Storage::disk('s3')->exists($filePath);            # 폴더가 있으면 ture 없으면 fasle

        Storage::disk('s3')->makeDirectory($filePath);     # 폴더가 없으면 해당 경로에 폴더를 만들어 줌 $filePath에 / 기준으로 폴더가 생성됨

        //$file = $request->file('image');                   # Request로 부터 불러온 정보를 변수에 저장 

        //$saveFilePath = $filePath . $name;                 # 저장 파일 경로 = 폴더 경로 + 파일 이름

        Storage::disk('s3')->put($saveFilePath, file_get_contents($file)); #7 설정한 경로로 파일 저장 + 전체파일을 문자열로 읽어들이는 PHP 함수

        return Storage::disk('s3')->url(); //s3 url 가져오는 함수
        #https://3s.ap-northeast-2.amazonaws.com/lanovebucket/1552473587KakaoTalk_20190217_222950301.png
        #https://s3.ap-northeast-2.amazonaws.com/lanovebucket/images/1552473587KakaoTalk_20190217_222950301.png
    }
}
