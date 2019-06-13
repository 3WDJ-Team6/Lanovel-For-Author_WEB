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

<!-- Main Content -->

<div class="container" style="margin-top:70px;">
    <!-- Material inline 1 -->
    <div class="form-check form-check-inline"
        style="width:100%; align-items: center; display: flex; justify-content: center;"></div>

    <div class="row">

        <div class="col-lg-12 col-md-10 mx-auto" style="margin-top:50px; margin-bottom:50px;" id="content_list_box">

            <div class="content_box" style="display:b  lock;">
                <div class="content_title">
                    <img src="{{asset('image/templatemo_content_title.png')}}" style=""></div>
                <div id="work_title_box"
                    style="height:50px; display:inline-block; margin-left:10%; margin-top:5%; margin-bottom:2%;">
                    <a href="{{url('editor/main/chapter')}}/{{$nowChapter['num_of_work']}}"
                        style="font-size:25px; color:black; text-decoration:none;">{{$nowChapter->subtitle}}</a>
                </div>

                <!-- {{-- 새 회차 추가  --}} -->
                <!-- <div class="post-preview" style="width:100%; height:100px; align-items: center; display: flex; justify-content: center;"> -->
                <div class="post-subtitle" style="width:100%; margin-left:8%;">
                    <a href="javascript:popup({{$num}})" target="_blank" style="color:black; text-decoration:none;">

                        <img src="{{asset('image/plus.png')}}"
                            style="width:40px; height:40px; margin-right:1%; display:inline-block;">

                        목차 추가</a>
                </div>
                <!-- </div> -->

                <!-- {{-- 회차 출력 부분  --}} -->
                @foreach( $chapter_of_works as $row )
                <div class="post-preview" style="height:100px; margin:1%; display:block;">
                    <a href="{{url('/editor')}}/{{$row['num']}}">
                        <div class="post-subtitle"
                            style="font-size:22px; display:inline-block; margin-left:7%; margin-top:2%; margin-bottom:2%;">
                            {{ $row->subsubtitle }}
                        </div>
                    </a>

                    <div class="button" style="display:inline-block; width:100px;">
                        <button type="button"
                            style="cursor: pointer;border: none; background-color:white; height:30px; margin-left:1%; display:inline-block;">
                            <img src="{{asset('image/edit.png')}}" title="수정"
                                style="text-align:center; height:100%; font-size:15px; background-color:white; color:#6c757d;"></button>
                        <button type="button"
                            style="cursor: pointer; border:none; background-color:white; height:30px; display:inline-block;">
                             <img src="{{asset('image/trash.png')}}" title="삭제"
                                style="text-align:center; height:100%; font-size:15px; background-color:white; color:#6c757d;"></button>
                        </button>
                    </div>
                    <div class="dot" style="display:inline-block;">
                        <!-- <hr style="border:0.5px dotted; width:100%;"> -->
                    </div>
                    <p class="post-meta" style="font-size:14px; margin-bottom:2%; display:block;  margin-left:7%;">
                        Posted
                        by {{Auth::user()['nickname']}} on {{Carbon::parse($row->created_at)->diffForHumans()}}</p>

                    <div class="button" style="width:80px; display:inline-block;">

                    </div>

                </div>
                @endforeach
                <div class="gototop">
                    <img src="{{asset('image/templatemo_gotoTop.jpg')}}" style="display:inline-block;">
                </div>
                <!-- Pager -->
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('footer')
@include('layouts.footer')
@endsection
