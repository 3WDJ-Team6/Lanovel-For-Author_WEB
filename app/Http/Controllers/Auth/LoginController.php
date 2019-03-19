<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
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
        return redirect()->intended('/'); // 로그인 하면 내가 요청했던 곳으로 감
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

        return $credentials;

        if (Auth::attempt($credentials)) {  //로그인 성공시
            echo "<script> alert('로그인 되었습니다.'); </script>";
            return redirect('/')->with('status', '로그인 되었습니다.');
            #redirect('/');
        } else {                            //로그인 실패시
            echo "<script>alert('존재하지 않는 아이디 이거나 비밀번호를 확인 해 주세요!');
            history.back();</script>";
            #redirect('/')->with('message', '존재하지 않는 아이디 이거나 비밀번호를 확인 해 주세요!');
        }
    }
}
