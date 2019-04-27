<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Traits\FileTrait; # file trait 추가

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const S3 = [
        's3Path' => 'https://s3.' . "ap-northeast-2" . '.amazonaws.com' . DIRECTORY_SEPARATOR . "lanovebucket" . DIRECTORY_SEPARATOR,
        'opsImage' => DIRECTORY_SEPARATOR . "OEBPS" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR
    ];

    // public function __construct()
    // {
    //     auth()->setDefaultDriver('api'); # make construct, use api auth
    // }
}
