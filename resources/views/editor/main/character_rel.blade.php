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
   google.load("jquery", "1.6.3");
   google.load("jqueryui", "1.8.16");
</script>
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/themes/base/jquery-ui.css"/>

@endsection

@section('content')
<div class="container" style="margin-top:70px;">
    <div>
        <div class="high-title text-center">인물 관계도</div>
    </div>
    <div id="jtk-demo-flowchart" class="jtk-demo-main" style="width:100%;margin-top:-4px;">
        <div class="inline-demo-container">
            <!-- 사이드바 -->
            <div class="sidebar node-palette">
                <div class="sidebar-item" id="character">등장인물</div>
                <div class="sidebar-item" id="arrow">화살표</div>
            </div>

            <!-- 캔버스에리어 -->
            <div class="jtk-demo-canvas jtk-surface" id="drop_canvas">
            </div>
        </div>
    </div>
</div>
<div class="jtk-dialog-overlay jtk-dialog-overlay-top jtk-dialog-overlay-x jtk-dialog-overlay-visible"
    data-position="top" data-axis="x" style="display: none; left: 447px;">
    <div class="jtk-dialog-title">이름 입력:</div>
    <div class="jtk-dialog-content"><input type="text" size="50" value="">
    </div>
    <div class="jtk-dialog-buttons"><button class="jtk-dialog-button jtk-dialog-button-ok">확인</button><button
            class="jtk-dialog-button jtk-dialog-button-cancel" jtk-cancel="true"
            style="visibility: visible;">취소</button></div>
</div>
@endsection

@section('footer')
@include('layouts.footer')
@endsection
