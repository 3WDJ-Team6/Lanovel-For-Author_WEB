@extends('layouts.store.master')

@section('head')
@include('layouts.store.head')
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery.min.js"></script>
<script src="{{asset('js/store/detail_view_image.js')}}"></script>
<!-- <link rel="stylesheet" href="{{asset('css/store/view_image.css')}}"> -->
<link rel="stylesheet" href="{{asset('css/store/view_comment.css')}}">
<style>
    .mySlides {
        display: none
    }

</style>



@endsection

@section('header')
@include('layouts.store.header')
@endsection

@section('content')

<body>


    <section class="new_arrivals_area" style="width:100%; margin-top:120px; margin-bottom:50px;">
        <!-- 전부 -->
        <div class="row" style="justify-content:center; width:100%;">

            <!-- 왼쪽 -->
            <div class="form-group"
                style="margin:40px; margin-top:50px; display:inline-block; width:550px; position:relative;">

                <!-- 메인사진 -->
                <div class="main-form" style="width: 550px; height: 350px; ">
                    <img src="{{$product->url_of_illustration}}"
                        style="width: 550px; height: 350px; cursor:pointer; position: absolute; display:inline-block; object-fit:cover;"
                        onclick="openModal();currentDiv(1)" class="w3-hover-shadow">
                    <img src="{{asset('image/store/illustore2.png')}}"
                        style="position: relative; margin-left:90px; margin-top:130px;">
                </div>
                <!-- 서브사진 -->
                <div class="form-group">

                    <div class="form-group"
                        style="width:570px; height:90px; cursor:pointer; margin-top:30px; margin-left:-10px;">
                        @foreach($posts as $post)
                        <img src="{{$post->url_of_illustration}}" class="w3-hover-shadow"
                            onclick="openModal();currentDiv(1)"
                            style="width:70px; height:70px; margin:10px; display:inline-block;">
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- 오른쪽 -->
            <div class="form-group" style=" width:700px; margin:30px; margin-top:50px; display:inline-block;">
                <div class="form-group" style=" background-color:#EAEAEA; height:350px;">
                    <!-- 제목/가격 -->
                    <div class="form-group" style="width:100%;">
                        <div class="title" name="illustration_title"
                            style="width:350px; margin:20px; display:inline-block;">
                            <h3>{{$product->illustration_title}}</h3>
                        </div>
                        <div class="price" name="price_of_illustration"
                            style="width:260px; margin:20px; text-align:right; display:inline-block;">
                            <h5>Price : {{$product->price_of_illustration}}

                                <button type="button" class="btn btn-light" data-toggle="modal"
                                    data-target="#alarmModal" style="width:80px;">구매</button> </h5>

                            <!-- Modal -->
                            <div class="modal fade" id="alarmModal" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content" style="align-content:start;">
                                        <div class="modal-header" style="align-content:start;">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel"></h4>
                                        </div>
                                        <div class="modal-body" style="align-content:start;">
                                            <h4 style="align-content:start;">해당 삽화를 구매하시겠습니까? &nbsp &nbsp &nbsp &nbsp
                                                &nbsp &nbsp &nbsp &nbsp
                                                &nbsp &nbsp </h4>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">취소</button>
                                            <button type="button"
                                                onclick="location.href='{{url('/buyIllust')}}/{{$product->num}}'"
                                                class="btn btn-primary">구매</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="nickname" name="nickname"
                        style="width:100%; text-align:center; margin:10px;text-align:left;">
                        <p>{{$product->nickname}}</p>
                    </div>
                    <div class="introduce" name="introduction_of_illustration"
                        style="width:100%; height:100px; margin:20px;">
                        <h5>{{$product->introduction_of_illustration}}</h5>
                        <div class="date" name="crated_at" style=" margin-top:0px;">
                            <p>{{$product->updated_at}}</p>
                        </div>
                    </div>
                    <div class="tag" name="tag"
                        style="width:100%; height:30px; margin-left:20px; display:inline-block;">

                        @foreach($tags as $tag)
                        <span class="badge badge-light">
                            #{{$tag->moreTag}}
                        </span>
                        @endforeach

                    </div>
                    <div class="form-group" style=" text-align:right; height:50px;">
                        <div class="" name="" style="width:400px; height:45px; margin:15px; display:inline-block;">
                            <button type="button" class="btn btn-light btn-like"
                                style="margin:10px; display:inline-block;"><img src="{{asset('image/store/like.png')}}"
                                    style="width:30px; height:30px;"></button>
                            <button type="button" class="btn btn-light" style="margin:10px;display:inline-block;"><img
                                    src="{{asset('image/store/share.png')}}" style="width:30px; height:30px;"></button>
                        </div>
                    </div>

                </div>
                <hr style="width:710px;">

                <div class="container">
                    <div class="row">
                        <div class="col-sm-10 col-sm-offset-1" id="logout" style="margin:0;">
                            <div class="page-header">
                            </div>
                            <div class="comment-tabs" style="width:700px;">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="active"><a href="#comments-logout" role="tab" data-toggle="tab"
                                            style="text-decoration:none;">
                                            <h4 class="reviews text-capitalize">Comments</h4>
                                        </a></li>
                                    <li><a href="#add-comment" role="tab" data-toggle="tab"
                                            style="text-decoration:none;">
                                            <h4 class="reviews text-capitalize" style="margin-left:20px;">Add comment
                                            </h4>
                                        </a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="comments-logout">
                                        <ul class="media-list">
                                            <li class="media">
                                                <a class="pull-left" href="#">
                                                    <img class="media-object img-circle"
                                                        style="width:60px; height:60px; margin:10px;"
                                                        src="https://s3.amazonaws.com/uifaces/faces/twitter/dancounsell/128.jpg"
                                                        alt="profile">
                                                </a>
                                                <div class="media-body">
                                                    <div class="well well-lg">
                                                        <h4 class="media-heading text-uppercase reviews">channel_on</h4>
                                                        <ul class="media-date text-uppercase reviews list-inline">
                                                            <p>2019.04.27</p>
                                                        </ul>
                                                        <p class="media-comment" style="width:550px;">
                                                            이 편지는 영국에서 최초로 시작되어 일년에 한 바퀴 돌면서 행운을 주었고..
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="media">
                                                <a class="pull-left" href="#">
                                                    <img class="media-object img-circle"
                                                        style="width:60px; height:60px; margin:10px;"
                                                        src="https://s3.amazonaws.com/uifaces/faces/twitter/lady_katherine/128.jpg"
                                                        alt="profile">
                                                </a>
                                                <div class="media-body">
                                                    <div class="well well-lg">
                                                        <h4 class="media-heading text-uppercase reviews">nico</h4>
                                                        <ul class="media-date text-uppercase reviews list-inline">
                                                            <p>2019.04.27</p>
                                                        </ul>
                                                        <p class="media-comment">
                                                            말이 안나올 정도로 멋집니다..! 민수오빠 목소리 돌려줘
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="collapse" id="replyTwo">
                                                    <ul class="media-list">
                                                        <li class="media media-replied">
                                                            <a class="pull-left" href="#">
                                                                <img class="media-object img-circle"
                                                                    src="https://s3.amazonaws.com/uifaces/faces/twitter/jackiesaik/128.jpg"
                                                                    alt="profile">
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="media">
                                                <a class="pull-left" href="#">
                                                    <img src="{{asset('image/store/chul.png')}}"
                                                        style="width:60px; height:60px; margin:10px;" alt="profile">
                                                </a>
                                                <div class="media-body">
                                                    <div class="well well-lg">
                                                        <h4 class="media-heading text-uppercase reviews">hong_chul</h4>
                                                        <ul class="media-date text-uppercase reviews list-inline">
                                                            <p>2019.04.27</p>
                                                        </ul>
                                                        <p class="media-comment">
                                                            멋진 그림이네요 ~
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="collapse" id="replyTwo">
                                                    <ul class="media-list">
                                                        <li class="media media-replied">
                                                            <a class="pull-left" href="#">
                                                                <img class="media-object img-circle"
                                                                    src="https://s3.amazonaws.com/uifaces/faces/twitter/jackiesaik/128.jpg"
                                                                    alt="profile">
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-pane" id="add-comment">
                                        <form action="#" method="post" class="form-horizontal" id="commentForm"
                                            role="form">
                                            <div class="form-group">
                                                <label for="email" class="col-sm-2 control-label">Comment</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" name="addComment" id="addComment"
                                                        rows="5"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button class="btn btn-success btn-circle text-uppercase"
                                                        type="submit" id="submitComment"><span
                                                            class="glyphicon glyphicon-send"></span> 등록</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-10 col-sm-offset-1" id="login">
                            <div class="page-header">
                                <h3 class="reviews">Leave your comment</h3>
                                <div class="logout">
                                    <button class="btn btn-default btn-circle text-uppercase" type="button"
                                        onclick="$('#login').hide(); $('#logout').show()">
                                        <span class="glyphicon glyphicon-off"></span> Login
                                    </button>
                                </div>
                            </div>
                            <div class="comment-tabs">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="active"><a href="#comments-login" role="tab" data-toggle="tab">
                                            <h4 class="reviews text-capitalize">Comments</h4>
                                        </a></li>
                                    <li><a href="#add-comment-disabled" role="tab" data-toggle="tab">
                                            <h4 class="reviews text-capitalize">Add comment</h4>
                                        </a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="comments-login">
                                        <ul class="media-list">
                                            <li class="media">
                                                <a class="pull-left" href="#">
                                                    <img class="media-object img-circle"
                                                        src="https://s3.amazonaws.com/uifaces/faces/twitter/dancounsell/128.jpg"
                                                        alt="profile">
                                                </a>
                                                <div class="media-body">
                                                    <div class="well well-lg">
                                                        <h4 class="media-heading text-uppercase reviews">Marco</h4>
                                                        <ul class="media-date text-uppercase reviews list-inline">
                                                            <li class="dd">22</li>
                                                            <li class="mm">09</li>
                                                            <li class="aaaa">2014</li>
                                                        </ul>
                                                        <p class="media-comment">
                                                            Great snippet! Thanks for sharing.
                                                        </p>
                                                    </div>
                                                </div>

                                            </li>

                                            <li class="media">
                                                <a class="pull-left" href="#">
                                                    <img class="media-object img-circle"
                                                        src="https://s3.amazonaws.com/uifaces/faces/twitter/lady_katherine/128.jpg"
                                                        alt="profile">
                                                </a>
                                                <div class="media-body">
                                                    <div class="well well-lg">
                                                        <h4 class="media-heading text-uppercase reviews">Kriztine</h4>
                                                        <ul class="media-date text-uppercase reviews list-inline">
                                                            <li class="dd">22</li>
                                                            <li class="mm">09</li>
                                                            <li class="aaaa">2014</li>
                                                        </ul>
                                                        <p class="media-comment">
                                                            Yehhhh... Thanks for sharing.
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w3-container">

                <div id="myModal" class="w3-modal w3-black">
                    <span class="w3-text-white w3-xxlarge w3-hover-text-grey w3-container w3-display-topright"
                        onclick="closeModal()" style="cursor:pointer; margin-top:10%;">×</span>
                    <div class="w3-modal-content">

                        <div class="w3-content" style="max-width:1200px; margin-top:10%; ">
                            @foreach ($posts as $post)
                            <img class="mySlides" src="{{$post->url_of_illustration}}"
                                style="width:1000px; height:400px;">
                            @endforeach
                            <div class="w3-row w3-black w3-center">
                                <div class="w3-display-container">
                                    <p id="caption"></p>
                                    <span class="w3-display-left w3-btn" onclick="plusDivs(-1)">❮</span>
                                    <span class="w3-display-right w3-btn" onclick="plusDivs(1)">❯</span>
                                </div>
                                @foreach($posts as $post)
                                <div class="w3-col s4" style="width:225px; height:150px;">
                                    <img class="demo w3-opacity w3-hover-opacity-off"
                                        src="{{$post->url_of_illustration}}" onclick="currentDiv(1)"
                                        alt="Nature and sunrise" style="width:225px; height:150px;">
                                </div>
                                <!-- <div class="w3-col s4">
                                    <img class="demo w3-opacity w3-hover-opacity-off"
                                        src="{{asset('image/store/img_snow_wide.jpg')}}" style="width:100%"
                                        onclick="currentDiv(2)" alt="French Alps">
                                </div>
                                <div class="w3-col s4">
                                    <img class="demo w3-opacity w3-hover-opacity-off"
                                        src="{{asset('image/store/img_mountains_wide.jpg')}}" style="width:100%"
                                        onclick="currentDiv(3)" alt="Mountains and fjords">
                                </div> -->
                                @endforeach

                            </div> <!-- End row -->
                        </div> <!-- End w3-content -->

                    </div> <!-- End modal content -->
                </div> <!-- End modal -->

            </div>




            <!-- </div> -->
        </div>

    </section>

    <script>
        $(document).ready(function () {
            $("#alarm").click(function () {
                console.log("ddd");

                $("#alarmModal").modal();

                console.log("aaa");

            });
        });

    </script>

</body>

@endsection

@section('footer')
@include('layouts.store.footer')
@endsection
