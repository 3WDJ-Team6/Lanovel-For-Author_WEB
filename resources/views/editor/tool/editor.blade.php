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
                <li class="nav-btn">미리보기</li>
                <li class="nav-btn">저장</li>
                <li class="nav-btn">발행</li>
            </ul>
        </div>
    </div>
</header>
@endsection

@section('content')
<div class="content">
    <div class="tool-bar">
        <div class="tool-btns"></div>
        <div class="tool-btns">
            <span class="btn tool-btn" id="episode">에피소드 관리</span>
            <span class="btn tool-btn" >템플릿</span>
            <span class="btn tool-btn" id="indent">자동들여쓰기</span>
            <span class="btn tool-btn" >루비</span>
            <span class="btn tool-btn" >리소스</span>
        </div>
    </div>
    <div class="area">
        <div class="ep_tem_area"></div>
        <div class="textarea" contentEditable="true">
            <h3>글을써봐요</h3>
            <p>
                니코니코니
            </p>
        </div>
        <div class="resource_area">
            <div class=""></div>
        </div>
    </div>
</div>
@endsection 