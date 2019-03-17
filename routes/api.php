<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\JwtLoginController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

#Jwt token Login add

Route::group([
    'namespace' => 'Auth',
    'middleware' => 'api',
    'prefix' => 'password'
], function () {
    Route::post('/login', [
        'as' => 'auth.login',
        'uses' => 'Auth\JwtLoginController@login'
    ]);

    Route::post('/posts', [
        'as' => 'posts.index',
        'uses' => 'Auth\PostController@index'
    ]);

    Route::get('/refresh', 'Auth/JwtLoginController@refresh');
});



// Route::Post('/loginpage', 'Auth/JwtLoginController@page');

// // Route::post('/login', 'Auth/JwtLoginController@login');


// Route::middleware('jwt.auth')->get('users', function () {
//     return auth('api')->user();
// });
