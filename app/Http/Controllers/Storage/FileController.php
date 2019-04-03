<?php

namespace App\Http\Controllers\Storage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;

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
        $imageUrl = Storage::disk('s3')->url('images' . '/');
        # 세션 로그인 한 유저 + 작업중인 곳의 정보

        $url = 'https://s3.' . "ap-northeast-2" . '.amazonaws.com/' . "lanovebucket" . '/'; # 기본 URL 여기서 Author/Illustrator 나뉨
        $files = Storage::disk('s3')->files($role . '/' . $userEmail . '/' . 'Public/');    # 파일 주소를 가르킴 

        // return response()->json($files, 200, [], JSON_PRETTY_PRINT); //어떤값이 오는지 확인
        $images = [];
        foreach ($files as $file) {
            $images[] = [
                'name' => str_replace('images/', '', $file), // $file 문자열에서 images/를 ''로 치환함
                'src' => $url . $file
            ];
        }
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

        $userEmail = Auth::user()['email'];
        $filePath = $role . '/' . $userEmail . '/' . 'Public/';

        if ($request->hasFile('image')) {                        #1 image 파일이 있으면
            if (!Storage::disk('s3')->exists($filePath)) {       #2 폴더가 있으면 ture 없으면 fasle, 없으면 하위 디렉토리까지 싹 만들어줌
                Storage::disk('s3')->makeDirectory($filePath);   #3 폴더가 없으면 해당 경로에 폴더를 만들어 줌 $filePath에 / 기준으로 폴더가 생성됨
            }
            $file = $request->file('image');                     #4 Request로 부터 불러온 정보를 변수에 저장 
            $name = time() . $file->getClientOriginalName();     #5 파일명이 겹칠 수 있으니 시간 + 원본명으로 저장
            $saveFilePath = $filePath . $name;                     #6 저장 파일 경로 = 폴더 경로 + 파일 이름
            Storage::disk('s3')->put($saveFilePath, file_get_contents($file)); #7 설정한 경로로 파일 저장 + 전체파일을 문자열로 읽어들이는 PHP 함수

            return back()->withSuccess('Image uploaded successfully');  #8 성공했을 시 이전 화면으로 복귀 (이후 ajax처리 해야할 부분)
        } else {
            echo "<script> alert('파일이 존재하지 않습니다.') <script/>";
            return redirect('/');
        }
    }

    public function destroy($image)
    {

        Storage::disk('s3')->delete('images/' . $image);    //$image = 삭제하려는 이미지명 

        return back()->withSuccess('Image was deleted successfully');
    }

    public function ft()
    {
        // $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
        Auth::user()['roles'] === 2 ? $role = "Author" : $role = "Illustrator";
        $userEmail = Auth::user()['email'];
        $imageUrl = Storage::disk('s3')->url('images' . '/');
        # 세션 로그인 한 유저 + 작업중인 곳의 정보

        $url = 'https://s3.' . "ap-northeast-2" . '.amazonaws.com/' . "lanovebucket" . '/';             #https://3s.ap-northeast-2.amazonaws.com/lanovebucket/1552473587KakaoTalk_20190217_222950301.png
        $images = [];                                                                                   #https://s3.ap-northeast-2.amazonaws.com/lanovebucket/images/1552473587KakaoTalk_20190217_222950301.png
        $files = Storage::disk('s3')->files($role . '/' . $userEmail . '/' . 'Public/'); //. $user . '/' . $title

        // return $url;
        #return response()->json($files, 200, [], JSON_PRETTY_PRINT); //어떤값이 오는지 확인

        foreach ($files as $file) {
            $images[] = [
                'name' => str_replace('images/', '', $file), // $file 문자열에서 images/를 ''로 치환함
                'src' => $url . $file
            ];
        }
        // return response()->json($images, 200, [], JSON_PRETTY_PRINT);
        return view('uploadAssets/uploadPage', compact('images'));
    }

    public function functionSet()
    {
        $originurl = 'https://s3.' . "ap-northeast-2" . '.amazonaws.com/' . "lanovebucket" . '/';

        $getFileName = $fileUrl->getClientOriginalName();

        $fileSize = file_size(Storage::disk('s3')->size('images/' . $imageName));

        $naming = time() . $file->getClientOriginalName(); # 시간 + 원본명으로 저장

        $request->hasFile('image');                        # image 파일이 있으면

        Storage::disk('s3')->exists($filePath);            # 폴더가 있으면 ture 없으면 fasle

        Storage::disk('s3')->makeDirectory($filePath);     # 폴더가 없으면 해당 경로에 폴더를 만들어 줌 $filePath에 / 기준으로 폴더가 생성됨

        $file = $request->file('image');                   # Request로 부터 불러온 정보를 변수에 저장 

        $saveFilePath = $filePath . $name;                 # 저장 파일 경로 = 폴더 경로 + 파일 이름

        Storage::disk('s3')->put($saveFilePath, file_get_contents($file)); #7 설정한 경로로 파일 저장 + 전체파일을 문자열로 읽어들이는 PHP 함수

        return Storage::disk('s3')->url(); //s3 url 가져오는 함수
        #https://3s.ap-northeast-2.amazonaws.com/lanovebucket/1552473587KakaoTalk_20190217_222950301.png
        #https://s3.ap-northeast-2.amazonaws.com/lanovebucket/images/1552473587KakaoTalk_20190217_222950301.png
    }
}
