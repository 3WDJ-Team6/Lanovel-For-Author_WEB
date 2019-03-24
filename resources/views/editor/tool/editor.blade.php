@extends('layouts.app')

@section('header')
<header>
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
                ep{{$ep['number']}}. {{$ep['title']}}<br>
                @endforeach
                </div>
                <div class="ep-btns">
                    <span class="btn ep-btn" id="ep-add">에피소드 추가</span>
                    <span class="btn ep-btn" id="ep-edit">에피소드 수정</span>
                    <span class="btn ep-btn" id="ep-del">에피소드 삭제</span>
                </div>
            </div>
            <div class="tem">템플릿
                <div ondrop="drop(this, event)">
                    <p ondragstart="dragStart(this, event)" draggable="true" id="tem1" title="zzzzzzzz">Template 1</p>
                    <p ondragstart="dragStart(this, event)" draggable="true" id="tem2" title="aaaaaaaaa">Template 2</p>
                </div>
            </div>
        </div>
        <div class="textarea" contentEditable="true" ondrop="drop(this, event)">
            <h3>
                物語《ものがたり》を書《か》きましょう  
            </h3>
            <p>
                にこにこに
            </p>
        </div>
        <div class="resource-area"></div>
    </div>
</div>
<script src="{{ asset('js/editor.js') }}" defer></script>
@endsection
