@extends('layouts.master')
@section('head')
@include('layouts.head')

@endsection

@section('header')
@include('layouts.header')
<link href="{{ asset('css/character_rel.css') }}" rel="stylesheet">
<script src="{{ asset('js/character_rel.js') }}" defer></script>
<script src="http://www.google.com/jsapi" type="text/javascript"></script>
<script type="text/javascript" >
    google.load("jquery", "1.6.3");google.load("jqueryui", "1.8.16");
</script>
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/themes/base/jquery-ui.css"/>

@endsection

@section('content')
<div class="container" style="margin-top:70px;">
    <div class="title">인물 관계도</div>
    <div class="area">
        <div class="inline-container">
            <!-- 사이드바 -->
            <div class="sidebar">
                <div class="sidebar-item" id="character">등장인물</div>
                <div class="sidebar-item" id="arrow">화살표</div>
            </div>

            <!-- 캔버스에리어 -->
            <div class="canvas-area" id="drop_canvas">
            </div>
        </div>
    </div>
</div>
<div class="character-modal">
    <div class="title">이름 입력</div>
    <div class="content">
        <input type="text" size="50" value="">
    </div>
    <div class="buttons">
        <button class="button-ok">확인</button>
        <button class="button-cancel" style="visibility: visible;">취소</button>
    </div>
</div>
@endsection

@section('footer')
@include('layouts.footer')
@endsection
