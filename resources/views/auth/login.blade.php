@extends('layouts.app')

@section('header')
<script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
<link href="{{ asset('/css/login_editor.css') }}" rel="stylesheet">
<style>
    li {
        display: inline;
        padding: 10px;
        float: left;
    }

</style>
@endsection

@section('content')

<input type="hidden" name="_token" value="{{ Session::token() }}">
<div class="container">

    <div class="overlay">
        <!-- <div class="image col-8"
            style="width:1000px; height:auto; position:absolute; z-index: 1; display:inline-block; margin-top:10%; margin-left:3%;">
            <img src="{{asset('image/people.png')}}" style="width:1000px; height:auto;">
        </div> -->
        <div class="right-box col-4" style="z-index: 2; margin-right:3%;">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <img src="image/editor_logo.png" class="rocky-dashed animate-pop-in" alt="logo" width="100%"
                    style="margin-bottom: 50px">
                <div class="header-title animate-pop-in">
                    <input placeholder=" example@gmail.com" id="email" type="email"
                        class="login{{ $errors->has('id') ? ' is-invalid' : '' }}" name="email" value="{{ old('id') }}"
                        required autofocus>

                    @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif

                    <input placeholder=" password" id="password" type="password"
                        class="login{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                    @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="header-subtitle animate-pop-in">
                    <ul>
                        <li><a id="kakao-login-btn"></a></li>
                        <li><button type="submit" class="login-btn">{{ __('로그인') }}</button></li>
                    </ul>
                </div>
                <div class="header-button animate-pop-in">
                    @if (Route::has('password.request'))
                    <a class="invis-btn" style="margin-left:20px" href="{{ route('password.request') }}">
                        <b>{{ __('아이디 / 비밀번호 찾기') }}</b>
                    </a>
                    @endif

                    <b><a class="invis-btn" href="">{{ __('회원가입') }}</a></b>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    Kakao.init('2c95436371fe2b214c00944d71b32514');
    // 카카오 로그인 버튼을 생성합니다.
    Kakao.Auth.createLoginButton({
        container: '#kakao-login-btn',
        success: function (authObj) {
            location.href = "{{url('auth/loginForKakao')}}";
            //alert(JSON.stringify(authObj));
        },
        fail: function (err) {
            alert(JSON.stringify(err));
        }
    });

</script>
@endsection
