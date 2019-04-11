<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Traits\FileTrait; # file trait 추가

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, FileTrait;
    // 전역변수 설정, 여기다가 trait도 설정해서 전역함수를 인스턴스에 올려서 사용하자

    const S3 = [
        's3Path' => 'https://s3.' . "ap-northeast-2" . '.amazonaws.com/' . "lanovebucket" . '/',
        'opsImage' => "/OEBPS" . '/' . "images/"
    ];

    const AUTHOR = [
        'workspace' => 'WorkSpace/',
    ];

    const BUCKET = [
        'bucketName' => 'lanovebucket',
        '' => ''
    ];

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

    public function getPublicS3Path($path)
    {
        Auth::user()['roles'] === 2 ? $role = "Author" : $role = "Illustrator"; # 세션 로그인 한 유저 + 작업중인 곳의 정보
        $userEmail = Auth::user()['email'];
        $files = Storage::disk('s3')->files($role . '/' . $userEmail . '/' . $path);

        return $files;
    }


    // public function __construct()
    // {
    //     auth()->setDefaultDriver('api'); # make construct, use api auth
    // }
}
