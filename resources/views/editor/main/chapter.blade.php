@extends('layouts.master')

@section('head')
@include('layouts.head')
<style>
    body {
        font-family: 'M PLUS Rounded 1c';
        background-color:#fffffa;
    }
</style>
<link rel="stylesheet" type="text/css" href="{{asset('css/normalize.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('css/demo.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('css/book.css')}}" />
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

<!-- Main Content -->
<div class="container" style="margin-top:3%; margin-botttom:3%;">
    @if(Session::has('success'))
    <div class="alert alert-info" style="margin-top:8%;border:none; color:white; background-color: #f1b875;">{{ Session::get('success') }}</div>
    @endif
    <!-- Material inline 1 -->
    <div class="form-check form-check-inline" style="width:100%;"></div>

    <!-- <div class="row"> -->
    <div class="col-lg-12 col-md-10 mx-auto" id="chapters_box" style="margin-top:50px; margin-bottom:50px;">
        <div id="work_title_box" style="margin-bottom:50px;">
            <h3 style="margin-bottom:20px;">
                @if(Auth::user()['roles']==2)<a href="/" style="color:#ea4c4c;">{{$nowWork->work_title}}</a></h3>
            @else
            <h4>{{$nowWork->work_title}}</h4>
            @endif

            <p>{{$nowWork->introduction_of_work}}</p>
        </div>
        <div class="chapter" style="align-items:center; justify-contents:center;">
            <div class="post-preview" style=" margin-top:0; width:90px; display:inline-block;">
                <h5 class="post-subtitle" style="display:inline-block; ">
                    <a href="javascript:popup({{$num}})" target="_blank"
                        style="display:block; color:black; text-decoration:none;">
                        <img src="{{asset('image/add.png')}}" alt="표지1"
                            style="width:60px; height:60px; margin-bottom:200%; display:block;">
                    </a>
                </h5>
            </div>

            @foreach($works as $row)

            @foreach($checkNum as $cn)
            @if($row->num == $cn->num)

            <div class="post-preview " style="display:inline-block; margin:3%">
            <ul class="align">
                <figure class='book'>
                    <a href="{{url('editor/main/list')}}/{{$row['num']}}" style="text-decoration:none;">
                        <ul class='hardcover_front'>
                            <li>
                                <div class="coverDesign yellow">
                                    <img src="{{asset('image/note.png')}}" alt="표지1" style="width:auto; height:220px;">
                                </div>
                            </li>
                            <li></li>
                        </ul>

                        <!-- Pages -->

                        <ul class='page'>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                            </ul>

                            <!-- Back -->

                            <ul class='hardcover_back'>
                                <li></li>
                                <li></li>
                            </ul>
                            <ul class='book_spine'>
                                <li></li>
                                <li></li>
                            </ul>
                        <!-- <div class="subtitle-form" style="display:inline-block;"> -->
                        <h5 class="post-subtitle"
                            style="display:flex; margin-left:2%; justify-content: center; align-items; center;">
                            {{$row->subtitle}}
                        </h5>
                        <!-- </div> -->

                    </a>
                </figure>
                </ul>
                <p class="post-meta"
                    style="font-size:13px; margin-bottom:0; display:flex; justify-content: center; align-items; center;">
                    Posted by {{Auth::user()['nickname']}} on May </p>
                <div class="button" style="display:flex; justify-content: center; align-items; center;">
                    <button type="button" style="cursor: pointer;border: none; background-color:white; height:25px;">
                        <img src="{{asset('image/edit.png')}}" title="수정"
                            style="text-align:center; height:100%; font-size:15px; background-color:white; color:#6c757d;"></button>
                    <button type="button" style="cursor: pointer;border: none; background-color:white; height:25px;">
                        <img src="{{asset('image/trash.png')}}" title="삭제"
                            style="text-align:center; height:100%; font-size:15px; background-color:white; color:#6c757d;"></button>
                    @if($cn->subsubtitle)
                    <button type="button" style="border: none; background-color:white;  height:25px;" id="push_alarm">
                        <a href="{{url('publication')}}/{{$row['num_of_work']}}/{{$row['num']}}">
                            <img src="{{asset('image/archive.png')}}" title="발행"
                                style="text-align:center;width:30px; height:100%; font-size:15px; background-color:white; color:#6c757d;">
                        </a>
                    </button>
                    @endif
                </div>
            </div>

            @break
            @endif
            @endforeach
            @endforeach
            <!-- </div> -->
            <!-- Pager -->

        </div>
    </div>
</div>


@endsection


@section('footer')
@include('layouts.footer')
@endsection