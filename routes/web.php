<?php

use App\Http\Controllers\Auth\LoginController;
use PHPUnit\Util\Json;
use Illuminate\Support\Facades\Auth;

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

Route::get('/test2', function () {
    if (Auth::user()) {
        return "asdasd";
    } else {
        return "fuc";
    }
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

Route::get('editor/main/book_add', function () {
    return view('editor.main.book_add');
});

Route::get('editor/main/popup_list', function () {
    return view('editor.main.popup_list');
});

Route::get('editor/main/popup_chapter', function () {
    return view('editor.main.popup_chapter');
});

Route::get('editor/main/chapter', function () {
    return view('editor.main.chapter');
});

Route::get('editor/main/series', function () {
    return view('editor.main.series');
});

Route::view('graph3', 'editor/main/graph3');


#
# aws s3 asset upload 기능  
Route::get('/assets/upload', 'Storage\FileController@index'); //view와 같이 폴더로 관리 make:controller folder/TestController 형식으로 만들어야함. 첫글자 다음문자 대문자.
Route::resource('/images', 'Storage\FileController', ['only' => ['store', 'destroy']]); // 해당 함수만 라우팅함
Route::get('ft', 'Storage\FileController@ft')->name('ft');

# authoriztion # make:auth로 생성 
Route::get('/home', 'HomeController@index')->name('home');

Auth::routes(); //로그인에 관한 모든 기능 연결

Route::view('test', 'auth/testlogin');

// Route::get('editor', function () {

Route::view('editor', 'editor/tool/editor');
Route::get('editor', function () {

    $episode = [
        [
            'title' => '첫번째 죽음',
            'number' => '1',
            'data' => 'data'
        ],
        [
            'title' => '12살 시절로',
            'number' => '2',
            'data' => 'data'
        ],
    ];
        
    return view('editor.tool.editor')->with('episode', $episode);
});
Route::get('res', 'ResourceController@index');
Route::view('ep_add', 'editor/tool/episode_add');
# kakao login
Route::get('loginForKakao', 'Auth\KakaginoLoController@index');
Route::get('auth/loginForKakao', 'Auth\KakaoLoginController@redirectToProvider');
Route::get('auth/kakaologincallback', 'Auth\KakaoLoginController@handleProviderCallback');