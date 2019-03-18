<?php

use App\Http\Controllers\Auth\LoginController;
use PHPUnit\Util\Json;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| WEB Route는 WEB 미들웨어를 사용하고
| API Route는 API 미들웨어를 사용한다.
| 웹 미들웨어는 CSRF 보호 및 세션과 같은 항목이 포함된다.
| API Route는 상태 비저장(stateless)고 WEB Route는 (stateful)이다.
|
|
*/


Route::get('/', function () {
    return view('index');
});

Route::get('editor/main/graph', function () {
    return view('editor.main.graph');
});

Route::get('login/editor', function () {
    return view('auth.login_editor');
});

Route::get('editor/main/list', function () {
    return view('editor/main/list');
});

Route::get('editor/tool/editor', function () {
    return view('editor.tool.editor');
});

#
# aws s3 ssset upload 기능  
Route::get('/assets/upload', 'Storage\FileController@index'); //view와 같이 폴더로 관리 make:controller folder/TestController 형식으로 만들어야함. 첫글자 다음문자 대문자.
Route::resource('/images', 'Storage\FileController', ['only' => ['store', 'destroy']]); // 해당 함수만 라우팅함

# authoriztion # make:auth로 생성 
Route::get('/home', 'HomeController@index')->name('home');
Auth::routes(); //로그인에 관한 모든 기능 연결
Route::view('editor', 'editor/tool/editor');

# kakao login
Route::get('loginForKakao', 'Auth\KakaoLoginController@index');
Route::get('auth/loginForKakao', 'Auth\KakaoLoginController@redirectToProvider');
Route::get('/auth/kakaologincallback', 'Auth\KakaoLoginController@handleProviderCallback');

Route::get('episode', function () {

    $episode = array(
        ['title' => 'title'],
        ['number' => 'number'],
        ['data' => 'data']
    );
    return response()->json($episode, 200);
});
