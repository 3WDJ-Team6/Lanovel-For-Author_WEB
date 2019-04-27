<?php

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Work;

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

// 새 작품 추가
Route::post('/addBook', 'WorkOut\IndexController@store')->name('addBook');

// 작품 수정 페이지
Route::get('/edit/{num}', 'WorkOut\IndexController@edit');

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

// 에디터 내에서 회차 추가
Route::post('/addContentInEditor/{num}', 'WorkOut\EditController@addContentInEditor');

// 에디터 내에서 회차 수정 페이지
Route::get('/content_edit_in_editor/{num}', 'WorkOut\EditController@content_edit_in_editor');

// 에디터 내에서 회차 수정
Route::post('/editContentInEditor/{num}', 'WorkOut\EditController@editContentInEditor');

// 작품 내용 저장
Route::post('/update/{num}', 'WorkOut\EditController@update');

// // 에디터에서 저장 후 회차 리스트 화면으로 back
Route::get('/redirectList/{num}', function () {
    return redirect('editor/main/list/{num}');
});

Route::post('/tr', 'WorkOut\EditController@store');

// 일러스토어 메인 페이지
Route::get('/store', 'WorkOut\IllustController@index')->name('store');

// 작가 그래프 페이지
Route::get('/graph', 'WorkOut\GraphController@index');

// 로그인
Route::get('/login/editor', function () {
    return view('auth.login_editor');
});

Route::get('/editor/main/book_add', function () {
    return view('editor.main.book_add');
});

Route::get('/editor/main/popup', function () {
    return view('editor.main.popup');
});

Route::view('/graph3', 'editor/main/graph3');

# aws s3 asset upload 기능
// Route::group(['prefix' => 'admin'], function () { }); prifix는 실제 api 요청하는 url의 앞 부분에 넘어온 문자열/ 로 url을 만듦 이 그룹에선 admin/~~
Route::group(['middleware' => ['auth',]], function () { # route 그룹안에 있는 route들은 해당 미들웨어를 거쳐서 감
    Route::get('/assets/upload', 'Storage\FileController@index'); //view와 같이 폴더로 관리 make:controller folder/TestController 형식으로 만들어야함. 첫글자 다음문자 대문자.
    Route::resource('/images/{folderPath?}/{bookNum?}', 'Storage\FileController', ['only' => ['store', 'destroy']]); // 해당 함수만 라우팅함
    Route::get('/lendbook', 'Storage\FileController@lendBook')->name('lendBook');
    # 일러스토어 일러스트 파일 업로드
    Route::post('/illustUpload', 'WorkOut\IllustController@illustUpload');
    Route::delete('/fileDelete/{id}', 'WorkOut\IllustController@fileDelete');
    # s3 directory dynamic listing
    Route::get('/getDir/{bookNum}/{dir?}', 'Storage\DirectoryController@index', ['only' => ['index', 'update', 'store', 'destroy']])->name('getDir');
});

# Mobile work info
Route::get('/worklists', 'Mobile\WorkListController@index');
Route::get('/works/{workNum}/{chapterNum}/{userId}', 'Mobile\WorkListController@show');

// Route::get('editor/tool/innerchat', 'Chat\ChatController@chat');
// Route::get('editor/innerchat', 'Chat|ChatController@chat');
// Route::get('innerchat', 'Chat\Controller@chat');
// Route::get('editor/tool/editor/innerchat', 'Chat\ChatController@chat');
// Route::get('chat', 'Chat\ChatController@chat');
// Route::post('send', 'Chat\ChatController@send');

# authoriztion # make:auth로 생성
Route::get('/home', 'HomeController@index')->name('home');
Auth::routes(); //로그인에 관한 모든 기능 연결


// 에디터 진입
Route::get('/editor/tool/editor/{num}', 'WorkOut\EditController@edit');

//리소스가져오기
Route::get('/res', 'WorkOut\EditController@res');

//메모
Route::post('/store_memo/{num_of_content}/{num}', 'WorkOut\EditController@store_memo');

# kakao login
Route::group(['middleware' => ['guest']], function () { # guest만 사용가능한 Route
    Route::get('/loginForKakao', 'Auth\KakaoLoginController@index');
    Route::get('/auth/loginForKakao', 'Auth\KakaoLoginController@redirectToProvider');
    Route::get('/auth/kakaologincallback', 'Auth\KakaoLoginController@handleProviderCallback');
});

// 일러스트 등록 페이지
Route::get('/illustCreate', 'WorkOut\IllustController@create');

// 일러스트 등록
Route::post('/illustStore', 'WorkOut\IllustController@store');

// 일러스토어 대메뉴 페이지
Route::get('/menu/{category}', 'WorkOut\IllustController@menuIndex');

// 일러스토어 상세메뉴 페이지
Route::get('/menu/{category}/{moreCategory}', 'WorkOut\IllustController@detailMenuIndex');

Route::post('store/find/search', function () {
    return view('store.find.search');
});

Route::get('/view/{num}', 'WorkOut\IllustController@detailView');

Route::get('store/menu/mypage', function () {
    return view('store.menu.mypage');
});

Route::post('/destroy', 'Auth\LoginController@destroy');

Route::get('publication/{NumOfWork}/{NumOfChapter}', 'Publish\PublicationController@publish');

Route::get('/new_collection', function () {
    return view('store.home.new_collection');
});
