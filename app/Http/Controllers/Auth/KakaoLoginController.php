<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Kakao;

class KakaoLoginController extends Controller
{
    public function index()
    {
        return view('auth.kakaoLogin');
    }

    public function redirectToprovider()
    {
        return Socialite::driver('kakao')->redirect();
    }


    public function handleProviderCallback()
    {
        # 로그인 하면 실행되며 로그인을 처리해  줌
        $kaUser = Socialite::driver('kakao')->stateless()->user();

        # return response()->json($kaUser, 200, [], JSON_PRETTY_PRINT); //어떤값이 오는지 확인

        $password = $kaUser->token;            //password
        $id = $kaUser->getId();                //id

        $nickname = $kaUser->getNickName();    // 프로필 명
        $profile_photo = $kaUser->getAvatar(); // 프로필 사진

        // return array(
        //     ["카톡 토큰" => $password],
        //     ["카톡 아이디" => $id],
        //     ["닉네임" => $nickname],
        //     ["프로필" => $profile_photo],
        // );

        # DB의 email과 카톡에서 가져온 비교, 없다면 생성
        if (!User::all()->where('email', $id)->first()) {
            // $user = new User();                              
            user::create([   //가져온 값으로 회원가입 시킴
                // $user->email = $id;                              
                'email' => $id,
                // $user->nickname = $nickname;                     
                'nickname' => $nickname,
                // $user->password = Hash::make($password);         
                'password' => Hash::make($password),
                // $user->profileImg = $profileImg;                 
                'profile_photo' => $profile_photo,
                // $user->save();                                   
            ]);
        } else {  //있다면 비밀번호를 업데이트 해줌
            User::where('email', "$id") //비교할 때 숫자랑 문자가 다를수도 있으니
                ->update(['password' => $password]);
            $oldImg = User::where('email', "$id")->value('profile_photo');
            User::where('profile_photo', "$oldImg")->update(['profile_photo' => "$profile_photo"]);
        }

        # 회원가입 후 로그인 
        if (Auth::attempt(['email' => $id, 'password' => $password])) {    // DB에 있는 토큰과 비교후 로그인
            \Log::debug("check = " . Auth::loginUsingId(Auth::id()));

            // echo "<script> alert('로그인 되었습니다.'); </script>";
            return redirect('/')->with('message', 'Socialite 로그인 성공');
            // return view('index', ['user' => $kaUser])->with('message', '로그인 되었습니다.');
        } else {
            echo "<script>alert('로그인에 실패하였습니다.');
            history.back();</script>";
            // return redirect()->intended('board');
        }
    }
}
