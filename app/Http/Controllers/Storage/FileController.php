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
        //r eturn $this->middleware('guest'); //guest이외의 사람에게는 이 컨트롤러를 사용하지 못하게 만든다.
        //return $this->middleware('auth');   //인증된 사용자만 이용할 수 있게 asset 업로드 사용할 수 있게, upload들어가면 url(login)이 실행됨.
    }

    public function index()
    {
        if (Auth::user()['role'] == 1) $role = "Author";
        else if (Auth::user()['role'] == 2) $role = "Illustrator";

        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
        $imageUrl = Storage::disk('s3')->url('images' . '/');
        # 세션 로그인 한 유저 + 작업중인 곳의 정보
        $user = Auth::user()['email'];
        $title = "title";
        $url = 'https://s3.' . "ap-northeast-2" . '.amazonaws.com/' . "lanovebucket" . '/';             #https://3s.ap-northeast-2.amazonaws.com/lanovebucket/1552473587KakaoTalk_20190217_222950301.png
        $images = [];                                                                                   #https://s3.ap-northeast-2.amazonaws.com/lanovebucket/images/1552473587KakaoTalk_20190217_222950301.png
        $files = Storage::disk('s3')->files('images/'); //. $user . '/' . $title

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

    public function store(Request $request) //image 등록
    {
        $this->validate($request, [ //|mimes:jpeg,png,jpg,gif,svg
            'image' => 'required|image|max:16384'   # image파일만 + 16MB까지
        ]);

        if ($request->hasFile('image')) { # image 파일이 있으면
            $file = $request->file('image');
            $name = time() . $file->getClientOriginalName(); // 시간 + 원본명
            $filePath = 'images/' . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
        }

        return back()->withSuccess('Image uploaded successfully');
    }

    public function destroy($image)
    {

        Storage::disk('s3')->delete('images/' . $image);    //$image = 삭제하려는 이미지명 

        return back()->withSuccess('Image was deleted successfully');
    }

    public function ft() // $originurl = 'https://s3.' . "ap-northeast-2" . '.amazonaws.com/' . "lanovebucket" . '/';
    {
        $originurl = 'https://s3.' . "ap-northeast-2" . '.amazonaws.com/' . "lanovebucket" . '/';

        $imageName = "1553132554떡볶이 양념.jpg";

        $fileUrl = Storage::disk('s3')->url('images' . '/' . $imageName);

        // $fileUrl = str_replace('/', '/', $test);

        $fileExists = Storage::disk('s3')->exists($fileUrl);

        $filesize = file_size(Storage::disk('s3')->size('images/' . $imageName));

        return 0;

        // $fileName = $fileUrl->getClientOriginalName();
        // return array(
        //     ['FileSize' => $filesize],
        //     ["FileUrl" => $fileUrl],
        //     ["FileName" => $fileName]
        // );

        // $storage = Storage::disk('s3');
        // $client = $storage->getAdapter()->getClient();
        // $command = $client->getCommand('ListObjects');
        // $command['Bucket'] = $storage->getAdapter()->getBucket();
        // $command['Prefix'] = 'path/to/FS_1054_';
        // return $result = $client->execute($command);
    }
}

//https://s3.ap-northeast-2.amazonaws.com/lanovebucket/images/1553132554%EB%96%A1%EB%B3%B6%EC%9D%B4+%EC%96%91%EB%85%90.jpg
