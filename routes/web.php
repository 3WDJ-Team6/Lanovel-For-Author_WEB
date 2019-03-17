<?php

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

Route::get('auth/login_editor', function () {
    return view('auth.login_editor');
});

Route::get('editor/main/list', function () {
    return view('editor/main/list');
});

