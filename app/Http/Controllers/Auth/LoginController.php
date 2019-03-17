<?php

namespace App\Http\Controllers\Auth;

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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {

        $creds = $request->only(['email', 'password']);

        if (!$token = auth()->attempt($creds)) { // 이 메서드가 실행되면 jwt-auth 패키지를 통해 실행됨.
            return response()->json(['error' => 'Incorrect email/password'], 401);  // 토큰 없으면 401(Unauthorized)페이지 반환.
        }

        return response()->json(['token' => $token]);   //인증완료시 JWT TOKEN 반환.
    }

    public function refresh()
    {
        try {
            $newToken = auth()->refresh();
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['error' => $e->getMessage()], 401); # return response()->json($data, state(200), $headers);
        }
        return response()->json(['token' => $newToken]);
    }
}
