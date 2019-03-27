@extends('layouts.app')

@section('header')
<header>
    <div class="title-bar">
        <span id="title">제목 - </span>
        <span id="chapter">챕터</span>
    </div>
    <div class="nav">
        <div class="nav-bar">
            <ul>
                <li class="nav-btn">ILLUSTORE</li>
                <li class="nav-btn">초대</li>
                <li class="nav-btn">채팅</li>
                <li class="nav-btn">멤버리스트</li>
                <li class="nav-btn" id="pre-btn"><a href="#preview" rel="modal:open" style="color:black;">미리보기</a></li>
                <li class="nav-btn">저장</li>
                <li class="nav-btn">발행</li>
            </ul>
        </div>
    </div>
</header>
@endsection

@section('content')
<div id="preview" class="modal">
    <p id="result"></p>
</div>
<div class="content">
    <div class="tool-bar">
        <div class="tool-btns"></div>
    </div>
    <div class="area">
        <div class="ep-tem-area">
            <div class="ep">
                <div class="ep-title">ep1. 첫번째 죽음</div>
                <div class="ep-list">
                @foreach ($episode as $ep)
                <span class="ep-li">ep{{$ep['number']}}. {{$ep['title']}}</span><br>
                @endforeach
                </div>
                <div class="ep-btns">
                    <span class="btn ep-btn" id="ep-add">에피소드 추가</span>
                    <span class="btn ep-btn" id="ep-edit">에피소드 수정</span>
                    <span class="btn ep-btn" id="ep-del">에피소드 삭제</span>
                </div>
            </div>
            <div class="tem">
                <div class="tem-title">템플릿</div>
                <div class="tem-list">
                    {{-- <div ondragstart="dragStart(this, event)" draggable="true" id="tem1" title="템플릿1">Template 1</div>
                    <div ondragstart="dragStart(this, event)" draggable="true" id="tem2" title="템플릿2">Template 2</div> --}}
                    <div class="tem-li" id="shadow">그림자</div>
                    <div class="tem-li" id="inshadow">내부그림자</div>
                    <div class="tem-li" id="spin">회전</div>
                    <div class="tem-li" id="radius">둥근모서리</div>
                    <div class="tem-li" id="oval">타원</div>
                    <div class="tem-li" id="circle">원</div>
                    <div class="tem-li" id="overlap">오버랩</div>
                    <div class="tem-li" id="blur">블러</div>
                    <div class="tem-li" id="album">사진첩</div>
                    <div class="tem-li" id="large">크게</div>
                    <div class="tem-li" id="small">작게</div>
                    <div class="tem-li" id="origin">원래사이즈</div>
                </div>
            </div>
        </div>
        <div class="textarea" contentEditable="true" ondrop="drop(this)">
            <p>
                物語《ものがたり》を書《か》きましょう  
            </p>
        </div>
        <div class="resource-area"></div>
    </div>
</div>
<script src="{{ asset('js/editor.js') }}" defer></script>
@endsection
