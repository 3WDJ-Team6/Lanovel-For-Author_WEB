<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Models\User;
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
    use AuthenticatesUsers;

    protected $redirectTo = '/';
    // protected function redirectTo()
    // {
    //     return route('login');
    // }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // public function username()
    // {
    //     return 'nickname';
    // }
    public function logout(Request $request)
    {
        auth()->logout(); #Auth::logout();
        return back()->withSuccess('로그아웃 하였습니다.');
    }

    public function store()
    {
        //로그인 검증

        return redirect()->intended('/'); // 로그인 하면 내가 요청했던 곳으로 감
    }
    #
    public function login(Request $request)
    {
        // return dd($request->server);
        // return $request->server('HTTP_USER_AGENT');
        $credentials = $request->only('email', 'password'); //회원 정보중 email, password만 가져옴
        // dd(Auth::attempt($credentials)); // type 반환
        // return $credentials;
        //post방식에서 redirect 권장하지 않음
        if (Auth::attempt($credentials)) {  # 로그인 성공시 (로그인 된 상태)

            //session id값을 header에 포함시켜 주고
            // if (strpos($request, 'Dalvik'))

            switch (Auth::user()['roles']) {
                case 1:
                    return response()->json(Auth::user(), 200);
                    break;
                case 2:
                    return redirect('/')->with('success', Auth::user()['nickname'] . "さま、ログインしました。")->with('success2',"現在リリースされた作品は総 4件です。");
                    break;
                case 3:
                    return redirect('/store')->with('success', '로그인 되었습니다');
                    break;
                default:
                    return back()->withSuccess('로그인 되었습니다');
                    break;
            }
            // return dd(Auth::user()['roles'] == 3);
        } else {  //로그인 실패시
            if (Auth::user()['roles'] === 1) {
                return false;
            } else {
                return redirect('/')->with('message', '존재하지 않는 아이디 이거나 비밀번호를 확인 해 주세요!');
            }
        }
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
}
