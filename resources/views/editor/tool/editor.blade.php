@extends('layouts.app')
@section('header')
<link href="https://fonts.googleapis.com/css?family=Kosugi+Maru&display=swap" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- <script src="{{ asset('js/app.js')}}"></script> --}}
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
<link href="{{ asset('css/editor.css?aaa') }}" rel="stylesheet">
@if(Auth::user()['roles'] == 2)
<script>
    var userRoles = "writer";
</script>
@elseif(Auth::user()['roles'] == 3)
<script>
    var userRoles = "illustrator";
</script>
@endif
@endsection

@section('content') {{-- 미리보기 --}}
{{-- 초대 --}}
<div class="content">

    {{-- 전체 에리어 --}}
    <div class="area">
            {{-- 타이틀과 목차 --}}
        <div class="title-bar">
            @foreach ($titles as $title)
            @if(Auth::user()['roles'] == 2)
            <a href="{{url('/')}}" id="title"><span id="work" style="font-size:2.2em;color:white;font-weight:800;margin-left:5%;">{{$title['work_title']}}</span></a>
            @else
            <button style="display:inline-block; font-size:25px; color:white; border:0; font-weight:800; background:transparent;">{{$title['work_title']}}</button>
            @endif

            @endforeach
            <form style="display: inline;margin-left:5%;" action="{{url('editor/main/list')}}/{{$content_of_works['num_of_chapter']}}">
                    @csrf
                    <span class="nav-btn"><span id="chatting">チャット</span></span>
                    <span class="nav-btn"><a id="inv_btn" href="{{url('/loadSearchModal')}}" rel="modal1:open" style="color:white;">招待</a></span>
                    <span class="nav-btn" id="mem-btn">メンバーリスト</span>
                    {{--<span class="nav-btn" id="pre-btn">--}}
                        <a id="pre-btn" href="#preview" rel="modal:open" style="color:white;">プレビュー</a>
                    {{--</span>--}}
                    <span class="nav-btn"><button type="submit" style="color:white;background:transparent;border:0;" id='sub'>保存</button></span>
            </form>
        </div>
        <div><img src="/image/tool_icon/edit_color_bar.png" style="margin-left:5%;width:57.7%" alt="edit_color_bar"></div>
        <div id="preview" class="modal">
            <p id="result"></p>
        </div>
    {{-- 상단 메뉴 --}}

        {{-- 글쓰는에리어 --}}
        <div id="popup_result" class="textarea" contentEditable="true" autocorrect="false">
            {!! $content_of_works['content'] !!}
        </div>

        <div id="member_list">
            @foreach($memberlist as $row)
            <div class="member_list_li"><img src="{{$row['profile_photo']}}" ></img>&nbsp;{{$row['nickname']}}</div>
            @endforeach
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
        <a href="{{url('/store')}}"><img class="illustore" src="/image/illust_btn_sm.png"></a>

    </div>
    {{-- 에피소드랑 템플릿 에리어 --}}
    <div class="ep-tem-area">
        <nav class="nav_left">
            <div class="ep-tem-par">
                <img class="ep-tem-bar" src="/image/tool_icon/edit_click_list.png" alt="">
                <span id="ep" class="ep-tem">リスト</span>
                <span id="tem" class="ep-tem">テンプレ</span>
            </div>
            <a id="menuToggle_left">
                <span class="sidebar_left"></span>
            </a>
            <div class="ep">
                {{--<div class="ep-title">
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
                </div>--}}
                <div class="ep-list">
                    {{-- 회차 리스트 띄워주기 --}}
                    <div><button onclick="javascript:popupInEditor({{$content_of_works['num_of_chapter']}})" class="ep_plus_btn"></button><b><span style="margin-left:5%;">追加</span></b></div>
                    @foreach($content_lists as $row)
                        <p class="ep-li"><b><span style="margin-left: 5%;margin-right:5%;">-</span><a href="{{url('/editor')}}/{{$row['num']}}" style="color:black;">{{$row['subsubtitle']}}<br></a></b></p>
                    @endforeach
                </div>
                <div class="ep-btns">
                    <span onclick="javascript:popupEdit({{$content_of_works['num']}})"><img class="ep_btn_icon"  src="/image/tool_icon/edit_edit.png" alt="edit_edit"></span>
                    <span><img class="ep_btn_icon"  src="/image/tool_icon/edit_delete.png" alt="edit_delete"></span>
                </div>
                {{--<div class="ep-btns">
                    <div class="btn ep-btn" onclick="javascript:popupInEditor({{$content_of_works['num_of_chapter']}})">追加</div>
                    <div class="btn ep-btn" onclick="javascript:popupEdit({{$content_of_works['num']}})">修正</div>
                    <div class="btn ep-btn" id="ep-del">削除</div>
                </div>--}}
            </div>
            {{-- 템플릿 에리어 --}}
            <div class="tem">
                <div class="tem-list">
                    {{--<div class="btn tem-li size_control" id="large">大きく</div>
                    <div class="btn tem-li size_control" id="small">小さく</div>
                    <div class="btn tem-li size_control" id="origin">元に</div>--}}
                    <span class="tem-li">
                        <div class="css_eft_control" id="css_eft_cB1"></div>
                        <span class="css_eft_name">桜1</span>
                    </span>
                    <span class="tem-li">
                        <div class="css_eft_control" id="css_eft_cB2"></div>
                        <span class="css_eft_name">桜２</span>
                    </span>
                    <span class="tem-li">
                        <div class="css_eft_control" id="css_eft_rain"></div>
                        <span class="css_eft_name">雨</span>
                    </span>
                    <span class="tem-li">
                        <div class="css_eft_control" id="css_eft_snow"></div>
                        <span class="css_eft_name">雪</span>
                    </span>
                    <span class="tem-li">
                        <div class="css_eft_control" id="css_eft_starlight"></div>
                        <span class="css_eft_name">きらきら</span>
                    </span>
                    <span class="tem-li">
                        <div class="css_eft_control" id="css_eft_yellowstar"></div>
                        <span class="css_eft_name">星</span>
                    </span>
                    <span class="tem-li">
                        <div class="css_eft_control" id="css_eft_lightning"></div>
                        <span class="css_eft_name">稲妻</span>
                    </span>
                </div>
                <div class="ep-btns">
                    <span class="size_control" id="large"><img class="ep_btn_icon" src="/image/tool_icon/edit_plus_btn.png" alt="edit_plus"></span>
                    <span class="size_control" id="small"><img class="ep_btn_icon" src="/image/tool_icon/edit_minus_btn.png" alt="edit_minus"></span>
                </div>
            </div>
        </nav>
    </div>
    {{-- 리소스 에리어 --}}
    <div class="resource-area">
        <form action="{{url('/images')}}" id="file_form" method="POST" enctype="multipart/form-data">
            @csrf
            <nav class="nav_right">
                <img class="resource-bar" src="/image/tool_icon/edit_folder_title.png" alt="">
                <a href="" id="menuToggle_right">
                    <span class="sidebar_right"></span>
                </a>
                <div id="resource-feild"></div>
            </nav>
        </form>
    </div>
    {{--<p id="prof-Ol2"
    style="position: absolute;top: 0px;left: 0px;opacity: 0.5;height: 100%;width: 100%;z-index: 65555;background-color: rgb(102, 102, 102);display: none;margin: 0;">
    </p>
    <p id="prof-Bg2" style="z-index: 65555;top: 100px;left: 35%;display: none;height: 240px;width: 644px;position: absolute;">
        <img id="prof-misaki2" class="prof2" src="/image/prof_misaki.jpg" style="width: 630px; height: 480px; display: none;">
        <audio id="audio_misaki2" src="https://s3.ap-northeast-2.amazonaws.com/lanovebucket/Author/authorID@google.com/sound/1563273127Misaki_hazimemashite1.mp3"></audio>
        <img id="prof-mashiro2" class="prof2" src="/image/prof_mashiro.jpg" style="width: 630px; height: 480px; display: none;">
        <audio id="audio_mashiro2" src="https://s3.ap-northeast-2.amazonaws.com/lanovebucket/Author/authorID@google.com/sound/1563273119Mashiro_yoroshiku.mp3"></audio>
        <img id="prof-nanami2" class="prof2" src="/image/prof_nanami.jpg" style="width: 630px; height: 480px; display: none;">
        <audio id="audio_nanami2" src="https://s3.ap-northeast-2.amazonaws.com/lanovebucket/Author/authorID@google.com/sound/1563273105Aoyama_yoroshiku.mp3"></audio>
        <img id="prof-sorata2" class="prof2" src="/image/prof_sorata.jpg" style="width: 630px; height: 480px; display: none;">
        <audio id="audio_sorata2" src="https://s3.ap-northeast-2.amazonaws.com/lanovebucket/Author/authorID@google.com/sound/1563273112Kanda_yoroshiku.mp3"></audio>
    </p>--}}

{{-- 채팅 --}}
<div id='ccc'></div>

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
            if ($("#caret").length) {
                $("#caret").remove();
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

<div id="ccc"></div>
@endsection
