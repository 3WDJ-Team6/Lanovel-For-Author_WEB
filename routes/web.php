<?php

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

// 작업방 메인 페이지
// Route::get('/', function() {
//     return view('index');
// });

Route::get('/', 'WorkOut\IndexController@index');

// 작품 추가 페이지
// Route::post('/create', 'WorkOut\IndexController@create');

// 새 작픔 추가
Route::post('/store', 'WorkOut\IndexController@store');

// 작품 수정 페이지
Route::get('/edit/{num}', 'WorkOut\IndexController@edit');

// 작품 수정
// Route::post('/update','WorkOut\IndexController@update');

// 작품 삭제

// 작품 챕터 페이지
Route::get('editor/main/chapter/{num}', 'WorkOut\IndexController@chapter_index');

// 작품 챕터 추가 페이지
Route::get('/chapter_create/{num}', 'WorkOut\IndexController@chapter_create');

// 작품 챕터 추가
Route::post('/addChapter/{num}', 'WorkOut\IndexController@addChapter');

// 작품 회차 페이지
Route::get('editor/main/list/{num}', 'WorkOut\EditController@index');

// 작품 회차 추가 페이지
Route::get('/content_create/{num}', 'WorkOut\EditController@content_create');

// 작품 회차 추가
Route::post('/addContent/{num}', 'WorkOut\EditController@addContent');


Route::get('editor/main/graph', function () {
    return view('editor.main.graph');
});

Route::get('login/editor', function () {
    return view('auth.login_editor');
});

// Route::get('editor/main/list', function () {
//     return view('editor/main/list');
// });

Route::get('editor/tool/editor', function () {
    return view('editor.tool.editor');
});

Route::get('editor/main/book_add', function () {
    return view('editor.main.book_add');
});

Route::get('editor/main/popup', function () {
    return view('editor.main.popup');
});



#
# aws s3 asset upload 기능  
Route::get('/assets/upload', 'Storage\FileController@index'); //view와 같이 폴더로 관리 make:controller folder/TestController 형식으로 만들어야함. 첫글자 다음문자 대문자.
Route::resource('/images', 'Storage\FileController', ['only' => ['store', 'destroy']]); // 해당 함수만 라우팅함
Route::get('ft', 'Storage\FileController@ft')->name('ft');

# authoriztion # make:auth로 생성 
Route::get('/home', 'HomeController@index')->name('home');
Auth::routes(); //로그인에 관한 모든 기능 연결


Route::view('test', 'auth/testlogin');

// 에디터 진입
Route::get('editor/tool/editor/{num}', 'WorkOut\EditController@edit');

// Route::view('editor', 'editor/tool/editor');

// 에디터 내용 저장
Route::post('/update', 'WorkOut\EditController@update');

Route::get('editor', function () {
    Route::view('graph3', 'editor/main/graph3');
    Route::get('editor_ep', function () {
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
    return view('editor.tool.editor_ep')->with('episode', $episode);
});
# kakao login
Route::get('loginForKakao', 'Auth\KakaoLoginController@index');
Route::get('auth/loginForKakao', 'Auth\KakaoLoginController@redirectToProvider');
Route::get('auth/kakaologincallback', 'Auth\KakaoLoginController@handleProviderCallback');
