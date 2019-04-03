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

Route::get('/', 'WorkOut\IndexController@index');

// 작품 추가 페이지
// Route::post('/create', 'WorkOut\IndexController@create');

// 새 작픔 추가
Route::post('/addBook', 'WorkOut\IndexController@store')->name('addBook');

// 작품 수정 페이지
Route::get('/edit/{num}', 'WorkOut\IndexController@edit');

// 작품 수정
// Route::post('/update','WorkOut\IndexController@update');

// 작품 삭제

// 작품 챕터 페이지
Route::get('/editor/main/chapter/{num}', 'WorkOut\IndexController@chapter_index');

// 작품 챕터 추가 페이지
Route::get('/chapter_create/{num}', 'WorkOut\IndexController@chapter_create');

// 작품 챕터 추가
Route::post('/addChapter/{num}', 'WorkOut\IndexController@addChapter');

// 작품 회차 페이지
Route::get('/editor/main/list/{num}', 'WorkOut\EditController@index');

// 작품 회차 추가 페이지
Route::get('/content_create/{num}', 'WorkOut\EditController@content_create');

// 작품 회차 수정 페이지
Route::get('/content_edit/{num}', 'WorkOut\EditController@content_edit');

// 작품 회차 추가
Route::post('/addContent/{num}', 'WorkOut\EditController@addContent');

// 작품 회차 수정
Route::post('/editContent/{num}', 'WorkOut\EditController@editContent');

// 에디터 내에서 회차 추가 페이지
Route::get('/content_create_in_editor/{num}', 'WorkOut\EditController@content_create_in_editor');

// 작품 
Route::post('/update/{num}', 'WorkOut\EditController@update');

// 북커버 등록
// Route::post('/setBookCover/{num}', 'WorkOut\EditorController@');

// // 에디터에서 저장 후 회차 리스트 화면으로 back
Route::get('/redirectList/{num}', function() {
    return redirect('editor/main/list/{num}');
});

Route::post('/tr', 'WorkOut\EditController@store');


Route::get('/editor/main/graph', function () {

    return view('editor.main.graph');
});

Route::get('/login/editor', function () {
    return view('auth.login_editor');
});

// Route::get('editor/main/list', function () {
//     return view('editor/main/list');
// });

Route::get('/editor/main/book_add', function () {
    return view('editor.main.book_add');
});

Route::get('/editor/main/popup', function () {
    return view('editor.main.popup');
});
Route::view('/graph3', 'editor/main/graph3');

# aws s3 asset upload 기능  
Route::get('/assets/upload', 'Storage\FileController@index'); //view와 같이 폴더로 관리 make:controller folder/TestController 형식으로 만들어야함. 첫글자 다음문자 대문자.
Route::resource('/images', 'Storage\FileController', ['only' => ['store', 'destroy']]); // 해당 함수만 라우팅함
Route::get('/ft', 'Storage\FileController@ft')->name('ft');
Route::get('/getDir', 'Storage\FileController@getDir')->name('getDir');


# authoriztion # make:auth로 생성 
Route::get('/home', 'HomeController@index')->name('home');
Auth::routes(); //로그인에 관한 모든 기능 연결

Route::view('test', 'auth/testlogin');

// Route::view('ep_add', 'editor/tool/episode_add');

// 에디터 진입
Route::get('/editor/tool/editor/{num}', 'WorkOut\EditController@edit');

//리소스가져오기
Route::post('/res', 'WorkOut\EditController@res');

// 에디터 내용 저장
Route::post('/update', 'WorkOut\EditController@update');
// Route::post('/send', 'WorkOut\EditController@send');

# kakao login
Route::get('/loginForKakao', 'Auth\KakaoLoginController@index');
Route::get('/auth/loginForKakao', 'Auth\KakaoLoginController@redirectToProvider');
Route::get('/auth/kakaologincallback', 'Auth\KakaoLoginController@handleProviderCallback');
