@extends('layouts.master')

@section('head')
@include('layouts.head')
<style>
    body {
        font-family: 'M PLUS Rounded 1c';
        background-color: #fffffa;
        overflow: hidden;
    }

</style>
<link rel="stylesheet" type="text/css" href="{{asset('css/chapter.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('css/normalize.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('css/demo.css')}}" />
<link href="https://fonts.googleapis.com/css?family=M+PLUS+Rounded+1c" rel="stylesheet">
<link href="{{asset('css/templatemo_style.css')}}" rel="stylesheet">
<script langauge="javascript">
    function popup(num) {
        var url = "/chapter_create/" + num;
        var option = "width=600, height=300, top=100"
        window.open(url, "", option);
    }

</script>

<script>
    jQuery(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#push_alarm').on("click", alarm);

        function alarm(e) {
            $.ajax({
                type: "POST",
                url: "https://fcm.googleapis.com/v1/projects/myproject-b5ae1/messages:send",
                data: {
                    notification: {
                        title: '구독작가 신작알림',
                        body: 'test'
                    }
                },
                dataType: "JSON",
                error: function (e) {
                    console.log("실패");
                },
                success: function (data) {
                    console.log(data);
                }
            });
        }
    });

</script>

@endsection

@section('header')
@include('layouts.header')
@endsection

@section('content')

<body>
    <!-- Main Content -->
    <div class="container" style="margin-top:3%; margin-botttom:3%;">

        <div class="background" style="position: absolute; z-index:-1; left:16%; top: 7.7%;">
            <img src="{{asset('image/main_box.png')}}" style="width:110%;">
        </div>

        @if(Session::has('success'))
        <div class="alert alert-info" style="margin-top:8%;border:none; color:white; background-color: #f1b875;">
            {{ Session::get('success') }}</div>
        @endif

        <!-- <div class="row"> -->
        <div class="" id="chapters_box"
            style="top: 10%; margin-top:50px; margin-bottom:50px; margin-right:19%; position:absolute; z-index:1">

            <div id="work_title_box" style="text-align: left; margin: 3%; display:block;">

                <h3 style="font-size:30px; margin-bottom:20px;">
                    @if(Auth::user()['roles']==2)<a href="/" style="color:black;">{{$nowWork->work_title}}</a>
                </h3>

                @else

                <h4>{{$nowWork->work_title}}</h4>

                @endif
                <img src="{{asset('image/color_bar.png')}}">
                <p style="margin-top:2%;">{{$nowWork->introduction_of_work}}</p>
            </div>

            <div class="chapter" style="position: absolute; z-index:-1; left:-4%; top: 55%;">
                <img src="{{asset('image/chapter_bar.png')}}" style="width:110.3%;">
            </div>



            <!-- <div class="post-preview" style="display:inline-block; float: left; margin: 4%; margin-top: 18%;">
                {{-- <a href="javascript:popup({{$num}})" target="_blank"> --}}
                    {{-- <img src="{{asset('image/chapter_add.png')}}" alt="표지1"> --}}
                </a>
            </div> -->
            <div style="height: 362px;">
                @foreach($works as $row)

                @foreach($checkNum as $cn)

                <span class="one" style="width:200px; height:350px;display:inline-block; margin-top:4%;margin-right:4%;">
                    <!-- 챕터 책 -->
                    <div class="post-preview " style="width:170px; height:270px;">
                        <a href="{{url('editor/main/list')}}/{{$row['num']}}" style="text-decoration:none;">
                            <img src="{{asset('image/note.png')}}" alt="표지1" style="width:100%; height:96%;">
                        </a>
                    </div>

                    <span class="bottom" style="width:300px;height:80px;">

                        <h5 class="post-subtitle" style="margin-left:-7%;">
                            {{$row->subtitle}}
                        </h5>

                        <p class="post-meta" style="font-size:13px;margin-left:-14%;">
                            Posted by {{Auth::user()['nickname']}} on May
                        </p>

                        <div class="button" style="margin-left:-6%">
                            <button type="button"
                                style="cursor: pointer;border: none; background-color:white; height:25px; ">
                                <img src="{{asset('image/chapter_edit.png')}}" title="수정"
                                    style="text-align:center; height:100%; font-size:15px; background-color:white; color:#6c757d;"></button>
                            <button type="button"
                                style="cursor: pointer;border: none; background-color:white; height:25px;">
                                <img src="{{asset('image/chapter_delete.png')}}" title="삭제"
                                    style="text-align:center; height:100%; font-size:15px; background-color:white; color:#6c757d;"></button>
                            @if($cn->subsubtitle)
                            <button type="button" style="border: none; background-color:white;  height:25px;"
                                id="push_alarm">
                                <a href="{{url('publication')}}/{{$row['num_of_work']}}/{{$row['num']}}">
                                    <img src="{{asset('image/archive.png')}}" title="발행"
                                        style="text-align:center;width:30px; height:100%; font-size:15px; background-color:white; color:#6c757d;">
                                </a>
                            </button>
                            @endif
                        </div>
                    </span>
                </span>
                @break

                @endforeach
                @endforeach
                <!-- </div> -->
                <!-- Pager -->
                <a href="{{url('/store')}}"><img class="illustore" src="/image/illust_btn_sm.png" style="    margin-left: -5%;
                    margin-top: 2%;"></a>
            </div>
        </div>
    </div>

</body>
@endsection
