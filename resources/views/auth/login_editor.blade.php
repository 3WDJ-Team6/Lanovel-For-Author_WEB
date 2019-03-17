@extends('layouts.app')

@section('content')
<div class="container">
    <div class="overlay">
        <div class="right-box">
            <form method="POST" action="{{ route('login') }}">
                @csrf


                <img src="image/editor_logo.png" alt="logo" width="100%" style="margin-bottom: 50px">

                <input placeholder=" ID" id="id" type="id" class="login{{ $errors->has('id') ? ' is-invalid' : '' }}" name="email"
                    value="{{ old('id') }}" required autofocus>

                @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif

                <input placeholder=" ******" id="password" type="password" class="login{{ $errors->has('password') ? ' is-invalid' : '' }}"
                    name="password" required>

                @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif


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
@endsection
