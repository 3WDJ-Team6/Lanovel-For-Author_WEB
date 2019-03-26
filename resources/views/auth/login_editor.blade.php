@extends('layouts.app')

@section('content')
<div class="container_bg">
    <div class="overlay">
        <div class="right-box">
            <form method="post" action="{{ route('login') }}">
                @csrf
                <img src="{{asset('/image/editor_logo.png')}}" alt="logo" width="100%" style="margin-bottom: 50px">

                <input placeholder="ID" id="email" type="email" class="login{{ $errors->has('id') ? ' is-invalid' : '' }}" name="email" value="{{ old('id') }}" required autofocus>

                @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif

                <input placeholder="******" id="password" type="password" class="login{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif

                <a id="kakao-login-btn"></a>

                <button type="submit" class="login-btn">
                    {{ __('로그인') }}
                </button>


                @if (Route::has('password.request'))
                <a class="invis-btn" style="margin-left:20px" href="{{ route('password.request') }}">
                    {{ __('아이디 / 비밀번호 찾기') }}
                </a>
                @endif

                <a class="invis-btn" href="">회원가입</a>

            </form>
        </div>
    </div>
</div>

<script>
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
</script>
@endsection 