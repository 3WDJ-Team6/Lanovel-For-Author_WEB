@extends('layouts.app')

@section('header')
<header>
    <div class="nav">
        <div class="nav-bar">
            <ul>
                <li class="nav-btn" onmouseover="">ILLUSTORE</li>
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
    </div>
    <div class="area">
        <div class="textarea" contentEditable="true">
            <h3>글을써봐요</h3>
            <p>
                니코니코니
            </p>
        </div>
    </div>
</div>
@endsection 