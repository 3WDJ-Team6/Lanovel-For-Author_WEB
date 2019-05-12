<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

#app은 api route 사용
Route::group(['prefix' => 'reader'], function () {
    Route::get('/worklists', 'Mobile\WorkListController@index');
    # 뷰어에 책 URL 전달 -> reader
    Route::get('/readBook/{bookNum?}/{bookTitle?}/{action?}', 'Mobile\BookController@show');
    # 도서 정보 전달 -> APP
    Route::get('/works/{workNum}/{chapterNum}/{userId}', 'Mobile\WorkListController@show');
    # 파일 구매시 다운로드  # Make Epub File
    Route::get('/downLoadBook/{folderPath?}/{bookNum?}', 'Storage\FileController@downLoadEpub');
});
