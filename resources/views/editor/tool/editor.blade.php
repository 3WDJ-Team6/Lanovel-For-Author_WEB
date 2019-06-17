@extends('layouts.app')
@section('header')
<link href="https://fonts.googleapis.com/css?family=Kosugi+Maru&display=swap" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{ asset('js/app.js')}}"></script>
<script>
    <?php $num_of_work = json_encode($content_of_works['num_of_work']); ?>
    var num_of_work = <?= $num_of_work ?>
</script>
<script>
    <?php $ep_of_num = json_encode($content_of_works['num']); ?>
    var ep_of_num = <?= $ep_of_num ?>
</script>
<script>
    var userNickname = "{{$user}}";
</script>
<script src="{{asset('/js/chat.js') }}"></script>
<script src="{{asset('/js/invite_user.js')}}"></script>
<script src="{{ asset('/js/editor.js') }}" defer></script>
<link href="{{ asset('css/editor.css?a') }}" rel="stylesheet">
@if(Auth::user()['roles'] == 2)
<script>
    var userRoles = "writer";
</script>
@elseif(Auth::user()['roles'] == 3)
<script>
    var userRoles = "illustrator";
</script>
@endif
<header>
    {{-- 타이틀과 목차 --}}
    <div class="title-bar">
        @foreach ($titles as $title)
        @if(Auth::user()['roles'] == 2)
        <a href="{{url('/')}}" id="title"><span id="work">
                <button style="display:inline-block; font-size:30px; color:#a1c45a; border:0; font-weight:800; background:transparent; margin-top:0.5%;">{{$title['work_title']}}</button>
            </span></a>
        @else
        <button style="display:inline-block; font-size:25px; color:#a1c45a; border:0; font-weight:800; background:transparent;">{{$title['work_title']}}</button>
        @endif
        <a href="{{url('editor/main/chapter')}}/{{$title['num']}}">
            <span id="chapter">
                &nbsp;&nbsp;&nbsp;<button style="display:inline-block; font-size:25px; color:#a1c45a; border:0; font-weight:800; background:transparent;">{{$title['subtitle']}}</button>
            </span>
        </a>
        @endforeach

    </div>
    <div id="ccc"></div>

    {{-- 상단 메뉴 --}}
    <div class="nav" style="display:inline-block; float:right; ">
    <div class="nav">
        <div class="nav-bar" style="margin-top:6%;">
            <form action="{{url('editor/main/list')}}/{{$content_of_works['num_of_chapter']}}">
                @csrf
                <ul>
                    {{-- <li class="nav-btn"><span id="chatting">채팅</span></li>--}}
                    <li class="nav-btn"><a id="inv_btn" href="{{url('/loadSearchModal')}}" rel="modal1:open" style="color:black;">초대</a></li>
                    <li class="nav-btn" id="mem-btn">멤버리스트</li>
                    <li class="nav-btn" id="pre-btn"><a href="#preview" rel="modal:open" style="color:black;">미리보기</a>
                    </li>
                    <li class="nav-btn"><button type="submit" id='sub'>저장</button></li>
                </ul>
            </form>
        </div>
    </div>
</header>
@endsection

@section('content') {{-- 미리보기 --}}
<div id="preview" class="modal">
    <p id="result"></p>
</div>
{{-- 초대 --}}
<div class="content">

    {{-- 전체 에리어 --}}
    <div class="area" style="height:600px;">
        {{-- 에피소드랑 템플릿 에리어 --}}
        <div class="ep-tem-area">
            <nav class="nav_left" style="top:86px; height:568px;">
                <div class="ep-tem-par">
                    <span id="ep" class="ep-tem">&nbsp;list&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <span id="tem" class="ep-tem">template</span>
                </div>
                <a id="menuToggle_left">
                    <span class="sidebar_left"></span>
                </a>
                <div class="ep">
                    <div class="ep-title">
                        <script>
                            var subsubtitle = "{!!$content_of_works['subsubtitle']!!}";
                            // 에피소드제목이 10 글자를 넘어갈경우 뒷부분...처리
                            if (subsubtitle.length >= 10) {
                                var changeSub = subsubtitle.substr(0, 10) + "...";
                                document.write(changeSub);
                            }
                            // 에피소드제목 출력
                            else {
                                document.write(subsubtitle);
                            }
                        </script>
                    </div>
                    <div class="ep-list">
                        {{-- 회차 리스트 띄워주기 --}} @foreach($content_lists as $row)
                        <p style=" margin:2.5% margin-top:5%;"><a href="{{url('/editor')}}/{{$row['num']}}" style="color:black;">{{$row['subsubtitle']}}<br></a></p>
                        @endforeach
                    </div>
                    <div class="ep-btns">
                        <div class="btn ep-btn" onclick="javascript:popupInEditor({{$content_of_works['num_of_chapter']}})">추가</div>
                        <div class="btn ep-btn" onclick="javascript:popupEdit({{$content_of_works['num']}})">수정</div>
                        <div class="btn ep-btn" id="ep-del">삭제</div>
                    </div>
                </div>
                {{-- 템플릿 에리어 --}}
                <div class="tem">
                    <div class="tem-list">
                        <div class="btn tem-li size_control" id="large">크게</div>
                        <div class="btn tem-li size_control" id="small">작게</div>
                        <div class="btn tem-li size_control" id="origin">원래사이즈</div>
                        <div class="btn tem-li css_eft_control" id="css_eft_cB1">
                            <div class="css_eft_name">벚꽃</div>
                        </div>
                        <div class="btn tem-li css_eft_control" id="css_eft_cB2">
                            <div class="css_eft_name">벚꽃</div>
                        </div>
                        <div class="btn tem-li css_eft_control" id="css_eft_rain">
                            <div class="css_eft_name">비</div>
                        </div>
                        <div class="btn tem-li css_eft_control" id="css_eft_snow">
                            <div class="css_eft_name">눈</div>
                        </div>
                        <div class="btn tem-li css_eft_control" id="css_eft_starlight">
                            <div class="css_eft_name">반짝임</div>
                        </div>
                        <div class="btn tem-li css_eft_control" id="css_eft_yellowstar">
                            <div class="css_eft_name">노란별</div>
                        </div>
                        <div class="btn tem-li css_eft_control" id="css_eft_lightning">
                            <div class="css_eft_name">번개</div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>

        {{-- 글쓰는에리어 --}}
        <div id="popup_result" class="textarea" contentEditable="true" autocorrect="false">
            {!! $content_of_works['content'] !!}
        </div>
        {{-- <span contentEditable="false" style="color: yellow">│시발</span> --}}
        {{-- 리소스 에리어 --}}
        <div class="resource-area">
            <form action="{{url('/images')}}" id="file_form" method="POST" enctype="multipart/form-data">
                @csrf
                <nav class="nav_right" style="top:86px; height:593px;">
                    <a href="" id="menuToggle_right">
                        <span class="sidebar_right"></span>
                    </a>
                    <div id="resource-feild"></div>
                </nav>
            </form>
        </div>

        {{-- 글쓰기도구팝업 --}}
        <div id="popbutton">
            <div class="tool_popup_box"></div>
        </div>

        {{-- 메모창 --}}
        {{--<div id="memoPopup">
            <span class="underline" contenteditable="true" autocorrect="false"></span>
        </div>--}}

        {{--<div class="focus_user" style="display:none;">
            {{$user}}
        </div>--}}
    </div>
    <div id="member_list">
            @foreach($memberlist as $row)
                <div class="member_list_li">&nbsp;{{$row['nickname']}}</div>
            @endforeach
    </div>
    <script>

        jQuery(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#sub').on("click", onSave);

            function onSave(e) {
                if ($(".textarea > .text_p > .focused").length) {
                    $(".textarea > .text_p > .focused").remove();
                }
                $.ajax({
                    type: "POST",
                    url: "/update/{!! json_encode($content_of_works['num']) !!}",
                    data: {
                        content: $('.textarea').html(),
                    },
                    dataType: "JSON",
                    error: function(e) {
                        throw new Error("실.패");
                    },
                    success: function(data) {
                        console.log(data);
                    }
                });
            }
        });

    </script>

    <script type="text/javascript">
        $(window).on("load", function() {
            new popTool("popup_result", "popbutton");
        });
    </script>
</div>
@include('layouts/footer')
@endsection
