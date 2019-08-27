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

// 에디터에서 저장 후 회차 리스트 화면으로 back
Route::get('/redirectList/{num}', function () {
    return redirect('editor/main/list/{num}');
});
// Route::post('/tr', 'WorkOut\EditController@store');
// 로그인
Route::get('/login/editor', function () {
    return view('auth.login_editor');
});

Route::view('/graph3', 'editor/main/graph3');

# 작가 페이지 (작품 등록)
Route::group(['middleware' => ['auth',]], function () {
    Route::get('/', 'WorkOut\IndexController@index');   // 작업방 메인 페이지
    Route::get('/createBook', 'WorkOut\IndexController@create');   // 작품 추가 페이지
    Route::post('/addBook', 'WorkOut\IndexController@store')->name('addBook');   // 새 작품 추가
    Route::get('/edit/{num}', 'WorkOut\IndexController@edit');   // 작품 수정 페이지
    Route::get('/editor/main/chapter/{num}', 'WorkOut\IndexController@chapter_index');   // 작품 챕터 페이지
    Route::get('/chapter_create/{num}', 'WorkOut\IndexController@chapter_create');   // 작품 챕터 추가 페이지
    Route::post('/addChapter/{num}', 'WorkOut\IndexController@addChapter');   // 작품 챕터 추가
    Route::view('/character_relationships', '/editor/main/character_rel');
});

# 에디터
Route::group(['middleware' => ['auth',]], function () {
    Route::get('/editor/main/list/{num}', 'WorkOut\EditController@index');   // 작품 회차 페이지
    Route::get('/content_create/{num}', 'WorkOut\EditController@content_create');   // 작품 회차 추가 페이지
    Route::post('/addContent/{num}', 'WorkOut\EditController@addContent');   // 작품 회차 추가
    Route::get('/content_edit/{num}', 'WorkOut\EditController@content_edit');   // 작품 회차 수정 페이지
    Route::post('/editContent/{num}', 'WorkOut\EditController@editContent');   // 작품 회차 수정
    Route::get('/editor/{num}', 'WorkOut\EditController@edit');   // 에디터 진입
    Route::get('/res', 'WorkOut\EditController@res');   // 에디터 내 리소스 호출
    // Route::post('/store_memo/{num_of_content}/{num}', 'WorkOut\EditController@store_memo');   // 에디터 내 메모
    Route::get('/content_create_in_editor/{num}', 'WorkOut\EditController@content_create_in_editor');   // 에디터 내에서 회차 추가 페이지
    Route::post('/addContentInEditor/{num}', 'WorkOut\EditController@addContentInEditor');   // 에디터 내에서 회차 추가
    Route::get('/content_edit_in_editor/{num}', 'WorkOut\EditController@content_edit_in_editor');   // 에디터 내에서 회차 수정 페이지
    Route::post('/editContentInEditor/{num}', 'WorkOut\EditController@editContentInEditor');   // 에디터 내에서 회차 수정
    Route::post('/update/{num}', 'WorkOut\EditController@update');   // 에디터 내용 저장
});

# 수익 그래프
Route::group(['middleware' => ['auth',]], function () {
    Route::get('/graph', 'WorkOut\GraphController@index');   // 작가 그래프 페이지
    Route::get('/illustGraph', 'WorkOut\GraphController@illustIndex');    // 일러스트레이터 그래프 페이지
});

# 일러스토어
Route::group(['middleware' => ['auth',]], function () {
    Route::get('/store', 'WorkOut\IllustController@index')->name('store');   // 일러스토어 메인 페이지
    Route::get('/illustCreate', 'WorkOut\IllustController@create');   // 일러스트 등록 페이지
    Route::post('/illustStore', 'WorkOut\IllustController@store');   // 일러스트 등록
    Route::get('/menu/{category}', 'WorkOut\IllustController@menuIndex');   // 일러스토어 대메뉴 페이지
    Route::get('/addCart/{num}', 'WorkOut\IllustController@addCart');   // 일러스토어 장바구니 추가
    Route::get('/view/{num}', 'WorkOut\IllustController@detailView');   // 일러스토어 상세보기 페이지
    Route::get('/myPage', 'WorkOut\IllustController@myPage');   // 일러스토어 마이페이지
    Route::get('/newCollection', 'WorkOut\IllustController@newContent');   // 일러스토어 뉴 콘텐츠 페이지
    Route::get('/addLike/{num}', 'WorkOut\IllustController@addLike');   // 일러스토어 좋아요
    Route::get('/buyIllust/{num}', 'WorkOut\IllustController@buyIllust');   // 일러스토어 구매
    Route::get('/buyIllustInCart', 'WorkOut\IllustController@buyIllustInCart');   // 일러스토어 장바구니 내역 구매
});

# aws s3 기능
Route::group(['middleware' => ['auth',]], function () { # route 그룹안에 있는 route들은 해당 미들웨어를 거쳐서 감
    Route::get('/assets/upload', 'Storage\FileController@index'); //view와 같이 폴더로 관리 make:controller folder/TestController 형식으로 만들어야함. 첫글자 다음문자 대문자.
    Route::resource('/images/{folderPath?}/{bookNum?}/{folderName?}', 'Storage\FileController', ['only' => ['store',]]); // 해당 함수만 라우팅
    Route::delete('/images/{folderPath?}/{bookNum?}/{folderName?}', 'Storage\FileController@destroy');
    # 일러스토어 일러스트 파일 업로드
    Route::post('/illustUpload', 'WorkOut\IllustController@illustUpload');
    Route::delete('/fileDelete/{id}', 'WorkOut\IllustController@fileDelete');
    # s3 directory dynamic listing
    Route::get('/getDir/{bookNum}/{dir?}/{forderName?}', 'Storage\DirectoryController@index', ['only' => ['index', 'update', 'store', 'destroy']])->name('getDir');
});

# pusher chat
Route::get('/editor/tool/editor/innerchat', 'Chat\ChatController@chat');
Route::post('/send', 'Chat\ChatController@send');
# fixed chat
Route::get('/getChat', 'Chat\ChatController@getChat');
Route::post('/messageSend', 'Chat\ChatController@messageSend');

Route::get('/home', 'HomeController@index')->name('home');
// 에디터 진입
Route::get('/editor/tool/editor/{num}', 'WorkOut\EditController@edit');

//메모
Route::post('/store_memo/{num_of_content}/{num}', 'WorkOut\EditController@store_memo');

Route::group(['middleware' => ['guest']], function () { # guest만 사용가능한 Route
    Route::get('/loginForKakao', 'Auth\KakaoLoginController@index');
    Route::get('/auth/loginForKakao', 'Auth\KakaoLoginController@redirectToProvider');
    Route::get('/auth/kakaologincallback', 'Auth\KakaoLoginController@handleProviderCallback');
});

// 일러스트 등록 페이지
// Route::get('/illustCreate', 'WorkOut\IllustController@create');

// 일러스트 등록
Route::post('/illustStore', 'WorkOut\IllustController@store');

// 일러스토어 대메뉴 페이지
Route::get('/menu/{category}', 'WorkOut\IllustController@menuIndex');

// 일러스토어 상세메뉴 페이지
Route::get('/menu/{category}/{moreCategory}', 'WorkOut\IllustController@detailMenuIndex');

Route::post('store/find/search', function () {
    return view('store.find.search');
});

// 일러스토어 장바구니 추가
Route::get('/addCart/{num}', 'WorkOut\IllustController@addCart');

// 장바구니
Route::get('/cartIndex', 'WorkOut\IllustController@cartIndex');
Route::get('/view/{num}', 'WorkOut\IllustController@detailView');
Route::get('/myPage', 'WorkOut\IllustController@myPage');

# authoriztion # make:auth로 생성
Auth::routes(); //로그인에 관한 모든 기능 연결

// 초대 메시지
Route::get('/loadSearchModal', 'InviteUser\InviteUserController@loadSearchModal');
Route::get('/loadUserInfoModal/{UserEmail}', 'InviteUser\InviteUserController@loadUserInfoModal');
Route::get('/inviteUser/{userid}', 'InviteUser\InviteUserController@loadInviteUserModal');
Route::post('/sendInviteMessage', 'InviteUser\InviteUserController@SendingInviteMessage');
Route::get('/viewMessages', 'InviteUser\InviteUserController@viewMessages');
Route::get('/viewMessage/{messageNum}', 'InviteUser\InviteUserController@viewMessage');
Route::get('/acceptInvite/{messageNum}/{workNum}', 'InviteUser\InviteUserController@acceptInvite');

Route::post('/destroy', 'Auth\LoginController@destroy');
// Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/oo', 'Mobile\ReviewController@index');
Route::get('publication/{NumOfWork}/{NumOfChapter}', 'Publish\PublicationController@publish');

Route::get('/share-evnet/{num}', 'WorkOut\EditController@edit');

Route::post('/postest/{nickname}/{num}', 'WorkOut\EditController@show');

Route::get('/getMyList', 'WorkOut\GraphController@index');
