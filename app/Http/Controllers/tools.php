<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class tools extends Controller
{

    public function makeS3Path($public, $userName, $s3Path)
    {
        Auth::user()['roles'] === 2 ? $role = "Author" : $role = "Illustrator"; # 세션 로그인 한 유저 + 작업중인 곳의 정보
        $userEmail = Auth::user()['email'];
        $publicPath = 'Public/';
        $url = 'https://s3.' . "ap-northeast-2" . '.amazonaws.com/' . "lanovebucket" . '/'; # 기본 URL 여기서 Author/Illustrator 나뉨
        $files = Storage::disk('s3')->files($role . '/' . $userEmail . '/' . $publicPath);

        $pullPath = $files;
        return $pullPath;
    }
}
