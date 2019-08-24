@extends('layouts.master')

@section('head')
@include('layouts.head')
<link href="{{asset('css/templatemo_style.css')}}" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=M+PLUS+Rounded+1c" rel="stylesheet">
@endsection

@section('header')
@include('layouts.header')
@endsection

@section('content')

<script langauge="javascript">
    function popup(num) {
        var url = "/content_create/" + num;
        var option = "width=600, height=300, top=100"
        newWindow = window.open(url, "", option);
    }

</script>
<style>
    ::-webkit-scrollbar {
        display: none;
    }

</style>
<!-- Main Content -->

<div class="container" style="margin-top:70px;">
    <div class="background" style="position: absolute; z-index:-1; left:16%; top: 7.7%;">
        <img src="{{asset('image/ep_all_back.png')}}" style="width:110%;">
    </div>

    <div class="col-lg-12 col-md-10 mx-auto" style="margin-top:50px; margin-bottom:50px;" id="content_list_box">
        <!-- 목차 책 -->
        <div class="post-preview "
            style="display:inline-block; width:200px; height:250px; margin-top:5%;margin-left: 5%;">
            <div class="coverDesign">
                <img src="{{asset('image/note.png')}}" alt="표지1" style="width:100%; height:100%;">
            </div>
        </div>
        <div id="work_title_box" style="display:inline-block; width:400px; margin-left:3%;">
            <a href="{{url('editor/main/chapter')}}/{{$nowChapter['num_of_work']}}"
                style="font-size:25px; color:black; text-decoration:none; ">{{$nowChapter->subtitle}}</a>
        </div>

        <div class="content_box" style="display:block;margin-top:5%; height: 430px;overflow-x:hidden">
            <!-- {{-- 새 회차 추가  --}} -->
            <div class="post-subtitle" style="width:100%; margin-left:8%; text-align:left;">
                <a href="javascript:popup({{$num}})" target="_blank" style="color:black; text-decoration:none;">
                    <img src="{{asset('image/add.png')}}" style="width:40px; height:40px; margin-right:1%; display:inline-block;">
                </a>
            </div>

            <!-- {{-- 회차 출력 부분  --}} -->
            @foreach( $chapter_of_works as $row )
            <div class="post-preview" style="height:100px; margin:1%; text-align:left;">
                <a href="{{url('/editor')}}/{{$row['num']}}">
                    <div class="post-subtitle"
                        style="font-size:22px; display:inline-block; margin-left:7%; margin-top:2%; margin-bottom:2%;">
                        {{ $row->subsubtitle }}
                    </div>
                </a>

                <div class="button" style="display:inline-block; width:100px;">
                    <button type="button"
                        style="cursor: pointer;border: none; background-color:transparent; height:30px; margin-left:1%; display:inline-block;">
                        <img src="{{asset('image/edit.png')}}" title="수정"
                            style="text-align:center; height:100%; font-size:15px; background-color:transparent; color:#6c757d;"></button>
                    <button type="button"
                        style="cursor: pointer; border:none; background-color:transparent; height:30px; display:inline-block;">
                        <img src="{{asset('image/trash.png')}}" title="삭제"
                            style="text-align:center; height:100%; font-size:15px; background-color:transparent; color:#6c757d;"></button>
                    </button>
                </div>
                <p class="post-meta" style="font-size:14px; margin-bottom:2%; display:block;  margin-left:7%;">
                    Posted by {{Auth::user()['nickname']}} on {{Carbon::parse($row->created_at)->diffForHumans()}}
                </p>
                <div class="button" style="width:80px; display:inline-block;"></div>

            </div>
            @endforeach

            <!-- Pager -->
        </div>
    </div>
    <a href="{{url('/store')}}"><img class="illustore" src="/image/illust_btn_sm.png" style="margin-left: 40%;margin-top: 5%;"></a>
</div>
@endsection
