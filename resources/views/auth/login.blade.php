@extends('layouts.app')

@section('header')
<script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
<link href="{{ asset('/css/login_editor.css?Aa') }}" rel="stylesheet">
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
    <!-- <div class="overlay"> -->
    <img class="whiteBox" src="/image/lg_back.png">
    <img src="{{asset('/image/writing_room_bg.png')}}" alt="writing_room_bg.png">
    <img src="{{asset('/image/logo.png')}}" class="rocky-dashed animate-pop-in logo_bg" alt="logo">
    <img src="{{asset('/image/writing_room_bg.png')}}" class="rocky-dashed animate-pop-in writing_bg" alt="logo">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="header-title animate-pop-in">
            <input placeholder=" example@gmail.com" id="email" type="email" class="login{{ $errors->has('id') ? ' is-invalid' : '' }}" name="email" value="{{ old('id') }}" required autofocus>

            @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
            @endif

            <input placeholder=" password" id="password" type="password" class="login{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>
            <div class="header-button animate-pop-in">
                <a class="invis-btn" style="margin-left:20px" href=""><b>{{ __('新規登録') }}</b></a>
                <b class="invis-btn">/</b>
                @if (Route::has('password.request'))
                <a class="invis-btn" href="{{ route('password.request') }}">
                    <b>{{ __('ログインできない場合') }}</b>
                </a>
                @endif
            </div>
            <div class="header-subtitle animate-pop-in">
                <ul style="margin-left:25%;">
                    <li><button type="submit" class="line"><img class="line_logo" src="/image/line_logo.png" alt="">&nbsp;{{ __('LINEでログイン') }}</button></li>
                    <li><button type="submit" class="login-btn">{{ __('ログイン') }}</button></li>
                </ul>
            </div>
        </form>
        <hr class="holine">
        <a href="{{url('/store')}}"><img class="illustore animate-pop-in" src="/image/illustore_btn.png"></a>

    <!-- </div> -->

</div>

{{-- <script>
    Kakao.init('2c95436371fe2b214c00944d71b32514');
    // 카카오 로그인 버튼을 생성합니다.
    Kakao.Auth.createLoginButton({
        container: '#kakao-login-btn',
        success: function(authObj) {
            location.href = "{{url('auth/loginForKakao')}}";
            //alert(JSON.stringify(authObj));
        },
        fail: function(err) {
            alert(JSON.stringify(err));
        }
    });
</script> --}}
@endsection
