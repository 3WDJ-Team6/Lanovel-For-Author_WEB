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

# Route::middleware('auth:api')->get('/user', function (Request $request) {return $request->user();});

#Jwt token Login add
# https://gracefullight.github.io/2017/11/03/Laravel-5-5-JWT-Auth-Guide/

// Route::Post('/loginpage', 'Auth/JwtLoginController@page');
// Route::post('/login', 'Auth/JwtLoginController@login');
// Route::middleware('jwt.auth')->get('users', function () {
//     return auth('api')->user();
// });
