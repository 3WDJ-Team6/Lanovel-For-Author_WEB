@extends('layouts.store.master')

@section('head')
@include('layouts.store.head')
<script src="//code.jquery.com/jquery.min.js"></script>
<script src="{{asset('js/store/detail_view_image.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/store/view_image.css')}}">
<link rel="stylesheet" href="{{asset('css/store/view_comment.css')}}">
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
                        style="width: 550px; height: 350px; position: absolute; display:inline-block; object-fit:cover;" onclick="openModal();currentSlide(1)"
                        class="hover-shadow cursor">
                    <img src="{{asset('image/store/illustore2.png')}}"
                        style="position: relative; margin-left:90px; margin-top:130px;">
                </div>
                <!-- 서브사진 -->
                <div class="form-group">

                    <div class="form-group" style="width:570px; height:90px; margin-top:30px; margin-left:-10px;">
                        @foreach($posts as $post)
                        <img src="{{$post->url_of_illustration}}" class="hover-shadow cursor"
                            onclick="openModal();currentSlide(1)"
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
                            <h5>Price : {{$product->price_of_illustration}} <button type="button" class="btn btn-light"
                                    style="width:80px;">구매</h5>
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
                        <div class="col-sm-10 col-sm-offset-1" id="logout">
                            <div class="page-header">
                            </div>
                            <div class="comment-tabs" style="width:700px;">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="active"><a href="#comments-logout" role="tab" data-toggle="tab">
                                            <h4 class="reviews text-capitalize">Comments</h4>
                                        </a></li>
                                    <li><a href="#add-comment" role="tab" data-toggle="tab">
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

            <!-- 모달창 -->
            <div id="myModal" class="modal" style="">
                <span class="close cursor" onclick="closeModal()">&times;</span>
                <div class="modal-content" style="width:1400px; height:500px;">
                    <div id="row" style="">
                        <!-- 상세보기 일러스트 -->
                        @foreach ($posts as $post)
                        <div class="mySlides " style="width:800px; height:500px; align-items: center;">
                            <!-- <div class="numbertext" style="color:black;">/{{$product->count}}</div> -->
                            <img src="{{$post->url_of_illustration}}" style=" width:800px; height:450px; display: inline-block; ">
                        </div>
                        @endforeach

                        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                        <a class="next" onclick="plusSlides(1)" style="margin-left:200px;">&#10095;</a>

                        <div class="caption-container">
                            <p id="caption"></p>
                        </div>

                        <!-- 그 외 일러스트 -->
                        <div class="bottom-form" style="">
                            @foreach($posts as $post)
                            <div class="column" style="display:inline-block; width:300px; height:200px;">
                                <img class="demo cursor" src="{{$post->url_of_illustration}}"
                                    style="width:300px; height:200px; display:inline-block;" onclick="currentSlide(1)"
                                    alt="Nature and sunrise">
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>


            <!-- </div> -->
        </div>

    </section>

</body>

@endsection

@section('footer')
@include('layouts.store.footer')
@endsection
