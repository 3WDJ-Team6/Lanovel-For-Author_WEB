<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    public function store()
    {
        //로그인 검증
        return redirect()->intended('board'); // 로그인 하면 내가 요청했던 곳으로 감
    }

    public function destroy()
    {
        auth()->logout();
        return redirect('/')->with('message', 'ありがとうございました。');
    }

    use AuthenticatesUsers;

    protected $redirectTo = '/';
    // protected function redirectTo()
    // {
    //     return '/';
    // }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        #$user = User::where('email', $request->email)->first();
        $credentials = $request->only('email', 'password'); //회원 정보중 email, password만 가져옴
        // return $credentials;

        if (Auth::attempt($credentials)) {  //로그인 성공시
            return "로그인 성공";
            #redirect('/');
        } else {                            //로그인 실패시
            return "존재하지 않는 아이디 이거나 비밀번호를 확인 해 주세요!";
            #redirect('/')->with('message', '존재하지 않는 아이디 이거나 비밀번호를 확인 해 주세요!');
        }
        // $creds = $request->only(['email', 'password']);
        // if (!$token = auth()->attempt($creds)) { // 이 메서드가 실행되면 jwt-auth 패키지를 통해 실행됨.
        //     return response()->json(['error' => 'Incorrect email/password'], 401);  // 토큰 없으면 401(Unauthorized)페이지 반환.
        // }
        // return response()->json(['token' => $token]);   //인증완료시 JWT TOKEN 반환.
    }
}
