@extends('layouts.app')
@section('header')

<header>
    {{-- 타이틀과 목차 --}}
    <div class="title-bar">
        @foreach ($titles as $title)
        <a href="{{url('/')}}" id="title"><span id="work">{{$title['work_title']}}</span></a>
        <a href="{{url('editor/main/chapter')}}/{{$title['num']}}"><span id="chapter"> {{$title['subtitle']}}</span></a>
        @endforeach
    </div>

    {{-- 상단 메뉴 --}}
    <div class="nav">
        <div class="nav-bar">
                <ul>
                    <li class="nav-btn">초대</li>
                    <li class="nav-btn">멤버리스트</li>
                    <li class="nav-btn" id="pre-btn"><a href="#preview" rel="modal:open" style="color:black;">미리보기</a>
                    </li>
                    <li class="nav-btn" id="send">저장</li>
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
    {{-- 툴버튼들 생성칸 --}}
    <div class="tool-bar">
        <div class="tool-btns"></div>
    </div>

    {{-- 전체 에리어 --}}
    <div class="area">
        {{-- 에피소드랑 템플릿 에리어 --}}
        <div class="ep-tem-area">
            {{-- 에피소드 에리어 --}}
            <div class="ep">
                <div class="ep-title">{{$content_of_works['subsubtitle']}}</div>
                <div class="ep-list">

                    <!-- {{-- 회차 리스트 띄워주기 --}}  -->
                    @foreach($content_lists as $row)
                    <a href="{{url('editor/tool/editor')}}/{{$row['num']}}" class="ep-li"> -
                        {{$row['subsubtitle']}}</a><br>
                    @endforeach

                </div>
                <div class="ep-btns">
                    <span class="btn ep-btn" id="ep-add">
                        {{-- <a href="javascript:popup({{$num}})" target="_blank"> --}}
                        에피소드 추가
                        {{-- </a> --}}
                    </span>
                    <span class="btn ep-btn" id="ep-edit">에피소드 수정</span>
                    <span class="btn ep-btn" id="ep-del">에피소드 삭제</span>
                </div>
            </div>

            {{-- 템플릿 에리어 --}}
            <div class="tem">
                <div class="tem-title">템플릿</div>
                <div class="tem-list">
                    {{--
                    <div ondragstart="dragStart(this, event)" draggable="true" id="tem1" title="템플릿1">Template 1</div>
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

        {{-- 글쓰는에리어 --}}
        <div id="popup_result" class="textarea" contentEditable="true" ondrop="drop(this, event)">
            {{$content_of_works['content']}}
            {{-- <div class="select">
                物語《ものがたり》を書《か》きましょう
            </div> --}}
        </div>

        {{-- 리소스 에리어 --}}
        <div class="resource-area"></div>

        {{-- 글쓰기도구팝업 --}}
        <div id="popbutton"
            style="display:none; Z-INDEX: 1; POSITION: absolute; background:#dddddd; top:0px; left:0px;">
            <button class="fontStyle" onclick="document.execCommand('italic',false,null);"
                title="Italicize Highlighted Text"><i>I</i>
            </button>
            <button class="fontStyle" onclick="document.execCommand( 'bold',false,null);"
                title="Bold Highlighted Text"><b>B</b>
            </button>
            <button class="fontStyle" onclick="document.execCommand( 'underline',false,null);"><u>U</u>
            </button>
            <button class="fontStyle" onclick="document.execCommand( 'strikeThrough',false,null);"><s>S</s>
            </button>
        </div>

        <script type="text/javascript">
            $(window).on("load", function () {
                new popTool("popup_result", "popbutton");
            });

        </script>
    </div>
</div>
<script src="{{ asset('/js/editor.js') }}" defer></script>
@endsection
