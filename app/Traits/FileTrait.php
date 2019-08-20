<?php

namespace App\Traits;

use Auth;
use App\Models\Work;
use Illuminate\Support\Facades\Storage;

trait FileTrait
{
    # 상속없이 클래스 멤버에 추가
    public function checkUserMakePath($folderPath = null, $bookNum = null, $folderName = null)
    {
        Auth::user()['roles'] === 2 ? $role = "Author" : $role = "Illustrator";

        $folderName == 'images' ? config('filesystems.disks.s3.images') : $folderName;

        switch ($folderPath) {
            case 'private':
                $filePath = $role . DIRECTORY_SEPARATOR . Auth::user()['email'] . DIRECTORY_SEPARATOR . $folderName . DIRECTORY_SEPARATOR;
                break;
            case 'public':
                if ($bookNum) {
                    $bookInfo = Work::select('users.email', 'works.num', 'works.work_title')
                        ->leftjoin('work_lists', 'works.num', 'work_lists.num_of_work')
                        ->leftjoin('users', 'work_lists.user_id', 'users.id')
                        ->where('works.num', '=', $bookNum)            //$num 숫자 부분은 변수로 전달 받아야함
                        ->orderBy('work_lists.created_at', 'asc')
                        ->first();  // 21번 작품을 쓴 작가 email = Author@test, bookTitle
                }
                $filePath = 'Author' . DIRECTORY_SEPARATOR . $bookInfo['email'] . DIRECTORY_SEPARATOR . 'WorkSpace' . DIRECTORY_SEPARATOR .
                    $bookInfo['work_title'] . DIRECTORY_SEPARATOR . 'OEBPS' . DIRECTORY_SEPARATOR . config('filesystems.disks.s3.images') . DIRECTORY_SEPARATOR;
                break;
            case 'WorkSpace':
                if ($bookNum) {
                    $bookInfo = Work::select('users.email', 'works.num', 'works.work_title')
                        ->leftjoin('work_lists', 'works.num', 'work_lists.num_of_work')
                        ->leftjoin('users', 'work_lists.user_id', 'users.id')
                        ->where('works.num', '=', $bookNum)
                        ->orderBy('work_lists.created_at', 'asc')
                        ->first();
                    $filePath = 'Author' . DIRECTORY_SEPARATOR . $bookInfo['email'] . DIRECTORY_SEPARATOR . 'WorkSpace' . DIRECTORY_SEPARATOR . $bookInfo['work_title'];
                } else {
                    return 'bookNum을 넘겨주세요';
                }
                break;
            case 'buy':
                $filePath = $role . DIRECTORY_SEPARATOR . Auth::user()['email'] . DIRECTORY_SEPARATOR . 'purchase' . DIRECTORY_SEPARATOR;
                if (!Storage::disk('s3')->exists($role . DIRECTORY_SEPARATOR . Auth::user()['email'] . DIRECTORY_SEPARATOR . 'purchase')) {
                    Storage::disk('s3')->makeDirectory($filePath, 0777, true);
                }
                break;
            default:
                $filePath = $role . DIRECTORY_SEPARATOR . Auth::user()['email'] . DIRECTORY_SEPARATOR . config('filesystems.disks.s3.images') . DIRECTORY_SEPARATOR;
                break;
        }

        return $filePath;
    }

    public function hasFile($request, $filePath)
    {
        if ($request->hasFile('image') || $request->hasFile('file')) {                                   #1 image 파일이 있으면
            if (!Storage::disk('s3')->exists($filePath)) {                  #2 폴더가 있으면 ture 없으면 fasle, 없으면 하위 디렉토리까지 싹 만들어줌
                Storage::disk('s3')->makeDirectory($filePath, 0777, true);  #3 폴더가 없으면 해당 경로에 폴더를 만들어 줌 $filePath에 / 기준으로 폴더가 생성됨
            }
        } else {
            return redirect('/')->withErrors('파일이 존재하지 않습니다.');
        }
    }

    function unicodeString($str, $encoding = null)
    {

        if (is_null($encoding)) $encoding = ini_get('mbstring.internal_encoding');

        return preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/u', function ($match) use ($encoding) {

            return mb_convert_encoding(pack('H*', $match[1]), $encoding, 'UTF-16BE');
        }, $str);
    }
}
