<?php
namespace App\Traits;

use Auth;
use Illuminate\Support\Facades\Storage;

trait FileTrait
{
    # 상속없이 클래스 멤버에 추가
    public function test()
    {
        return 'test';
    }

    public function checkUserMakePath()
    {
        Auth::user()['roles'] === 2 ? $role = "Author" : $role = "Illustrator";
        $filePath = $role . DIRECTORY_SEPARATOR . Auth::user()['email'] . DIRECTORY_SEPARATOR . config('filesystems.disks.s3.images') . DIRECTORY_SEPARATOR;
        return $filePath;
    }

    public function hasFile($request, $filePath)
    {
        if ($request->hasFile('image')) {                                   #1 image 파일이 있으면
            if (!Storage::disk('s3')->exists($filePath)) {                  #2 폴더가 있으면 ture 없으면 fasle, 없으면 하위 디렉토리까지 싹 만들어줌
                Storage::disk('s3')->makeDirectory($filePath, 0777, true);  #3 폴더가 없으면 해당 경로에 폴더를 만들어 줌 $filePath에 / 기준으로 폴더가 생성됨
            }
        } else {
            return redirect('/')->withErrors('이미지가 존재하지 않습니다.');
        }
    }
}
