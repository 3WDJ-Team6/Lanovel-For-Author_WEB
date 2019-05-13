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
    <div class="form-check form-check-inline" style="width:100%; align-items: center; display: flex; justify-content: center;"></div>

    <div class="row">

        <div class="col-lg-12 col-md-10 mx-auto" style="margin-top:50px; margin-bottom:50px;" id="content_list_box">

            <div class="content_box" style="display:block;">
                <div class="content_title">
                    <img src="{{asset('image/templatemo_content_title.png')}}" style=""></div>
                <div id="work_title_box" style="display:inline-block; margin-left:10%; margin-top:6%; margin-bottom:5%;">
                    <a href="{{url('editor/main/chapter')}}/{{$nowChapter['num_of_work']}}" style="font-size:25px; color:black; text-decoration:none;">{{$nowChapter->subtitle}}</a>
                </div>
                <hr>
                <!-- {{-- 새 회차 추가  --}} -->
                <div class="post-preview" style="height:150px;">
                    <h3 class="post-subtitle" style="margin:2%; margin-left:5%; display:inline-block;">
                        <a href="javascript:popup({{$num}})" target="_blank" style="color:black; text-decoration:none;">
                            <img src="{{asset('image/plus.png')}}" style="width:100px; height:100px; display:inline-block;">
                            목차 추가</a>
                    </h3>
                </div>
                <hr>

                <!-- {{-- 회차 출력 부분  --}} -->
                @foreach( $chapter_of_works as $row )
                <div class="post-preview" style="height:150px; ">
                    <a href="{{url('/editor')}}/{{$row['num']}}">
                        <h3 class="post-subtitle" style="display:inline-block; margin-left:5%; margin-top:4%; margin-bottom:4%;">
                            {{ $row->subsubtitle }}
                        </h3>
                    </a>
                    <p class="post-meta" style="margin-left:5%; margin-bottom:2%; display:block; font-size=10px;">Last Modified by {{ Auth::user()['nickname'] }} on {{ Carbon::parse($row->created_at)->diffForHumans() }}</p>
                </div>
                <hr>
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



@section('footer')
@include('layouts.footer')
@endsection
