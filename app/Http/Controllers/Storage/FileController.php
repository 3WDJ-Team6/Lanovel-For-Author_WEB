<?php

namespace App\Http\Controllers\Storage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Auth;
use App\Http\Requests\FilePost;
use App\Http\Controllers\tools;
use Aws\AwsClientTrait;
use App\Traits\FileTrait;

# https://laracasts.com/discuss/channels/laravel/how-to-get-properties-name-size-type-of-a-file-retrieved-from-storage?page=1
# 컨트롤러 전역함수 만들어서 쓰기

class FileController extends Controller
{
    use FileTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        Auth::user()['roles'] === 2 ? $role = "Author" : $role = "Illustrator";
        $files = Storage::disk('s3')->files($role . DIRECTORY_SEPARATOR . Auth::user()['email'] . DIRECTORY_SEPARATOR . config('filesystems.disks.s3.images'));    # 파일 주소를 가르킴

        // return response()->json($files, 200, [], JSON_PRETTY_PRINT); //값이 확인
        $images = [];
        foreach ($files as $file) {
            $images[] = [
                'name' => str_replace($role . '/' . Auth::user()['email'] . '/' . config('filesystems.disks.s3.images') . '/', '', $file), # issue : 삭제 안되던 것 name att 추가한 뒤로 정상 작동 $file에서 경로명 다 ''로 지우고 파일명만 등록
                'size' => file_size(Storage::disk('s3')->size($file)),                          # file 하나하나 접근해서 size를 가져옴
                'path' => $file,                                                                # $file 문자열에서 images/를 ''로 치환함 어디서 쓸 수 있을까?
                'src' => config('filesystems.disks.s3.url') . $file,                            # img src에서 접근할 수 있는 파일 주소  Carbon settimezone 설정가능
                'updated_at' => str_replace('000000', '', Carbon::createFromTimestamp(Storage::disk('s3')->lastModified($file))),  # 마지막에 파일이 업데이트 되었을 때 타임 스탬프값(unix값) 시간 포맷 https://stackoverflow.com/questions/10040291/converting-a-unix-timestamp-to-formatted-date-string
                'type' => Storage::disk('s3')->getMimeType($file),
            ];
        }
        // 'metadata' => Storage::disk('s3')->getMetadata($file) / 모든 메타데이터 가져옴
        // return response()->json($images, 200, [], JSON_PRETTY_PRINT);
        return view('uploadAssets/uploadPage', compact('images'));

        // $request->file('file')->storeAs(
        //     $storage,   //저장소 명 URL
        //     $file,      //들어온 파일
        //     's3'        //S3에 저장하겠다
        // );
    }

    public function store(FilePost $request, $folderPath = null, $bookNum = null)                        #0 파일 저장하는 컨트롤러 asset store & editor 사용
    {
        // // $validated = $request->validated();                   #유효성 검사가 실패하면 responese가 생성되어 이전 위치로 되돌려 보냄.

        $filePath = $this->checkUserMakePath($folderPath, $bookNum);
        $this->hasFile($request, $filePath);                         #1~3 FileTrait에서 처리해줌

        $file = $request->file('image');                             #4 Request로 부터 불러온 정보를 변수에 저장
        $name = time() . $file->getClientOriginalName();             #5 파일명이 겹칠 수 있으니 시간 + 원본명으로 저장
        $saveFilePath = $filePath . $name;                           #6 저장 파일 경로 = 폴더 경로 + 파일 이름
        Storage::disk('s3')->put($saveFilePath, file_get_contents($file), [ #7 설정한 경로로 파일 저장 + 전체파일을 문자열로 읽어들이는 PHP 함수
            'visibility' => 'public',
            'Metadata' => ['Content-Type' => 'image/jpeg'],
            // 'Expires' => now()->addMinute(5),                        #7 expire 현재시간 + 5분 적용 외않되
        ]);
        return back()->withSuccess('Image uploaded successfully');   #8 성공했을 시 이전 화면으로 복귀 (이후 ajax처리 해야할 부분)
    }

    public function destroy($image)
    {
        $filePath = $this->checkUserMakePath();
        Storage::disk('s3')->delete($filePath . $image);    //$image = 삭제하려는 이미지명
        // return back()->withSuccess('성공적으로 삭제 되었습니다.');
    }

    public function deleteFile(Request $request)
    {

        return $request;
    }

    public function lendBook()
    {
        // Storage::disk('s3')->getDriver()->put('Path', 'test?', ['visibillity' => 'public', 'Expires, GMT date()']);
        return Storage::disk('s3')->get('Author');
    }

    public function functionSet()
    {

        Storage::disk('s3')->directories(); #해당 경로에 있는 모든 directory (폴더만)

        Storage::disk('s3')->allFiles();    #해당 경로에 있는 모든 file (파일만)

        $fileSize = file_size(Storage::disk('s3')->size('images/' . $imageName));

        $naming = time() . $file->getClientOriginalName(); # 시간 + 원본명으로 저장

        //$request->hasFile('image');                        # image 파일이 있으면

        Storage::disk('s3')->exists($filePath);            # 폴더가 있으면 ture 없으면 fasle

        Storage::disk('s3')->makeDirectory($filePath, 0777, true);    # 폴더가 없으면 해당 경로에 폴더를 만들어 줌 $filePath에 / 기준으로 폴더가 생성됨

        //$file = $request->file('image');                   # Request로 부터 불러온 정보를 변수에 저장

        //$saveFilePath = $filePath . $name;                 # 저장 파일 경로 = 폴더 경로 + 파일 이름

        Storage::disk('s3')->put($saveFilePath, file_get_contents($file)); #7 설정한 경로로 파일 저장 + 전체파일을 문자열로 읽어들이는 PHP 함수

        // $images = Storage::disk('s3')->allFiles('oldfolder/image/');
        // foreach ($images as $image) {
        //     $new_loc = str_replace('oldfolder/image/', 'newfolder/image/', $image);
        //     $s3->copy($image, $new_loc);
        // }
        return Storage::disk('s3')->url(); //s3 url 가져오는 함수

    }
}
