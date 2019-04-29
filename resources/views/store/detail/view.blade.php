@extends('layouts.store.master')

@section('head')
@include('layouts.store.head')
<script src="{{asset('js/store/detail_view_image.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/store/view_image.css')}}">
<link rel="stylesheet" href="{{asset('css/store/view_comment.css')}}">
@endsection

@section('header')
@include('layouts.store.header')
@endsection

@section('content')

<body>
    <section class="new_arrivals_area" style="width:100%; margin-top:100px; margin-bottom:50px;">
        <h2 style="text-align:center; color:black;">My page</h2>
        <!-- 전부 -->
        <div class="row" style="justify-content:center; width:100%;">

            <!-- 사진칸 -->
            <div class="form-group" style="margin:30px; display:inline-block;">
                <!-- 왼쪽 -->
                <img src="{{$product->url_of_illustration}}" style="width: 500px; height: 300px;"
                    onclick="openModal();currentSlide(1)" class="hover-shadow cursor">
            </div>
            <!-- 오른쪽 -->
            <div class="form-group" display:inline-block;>
                <div class="title" name="illustration_title"
                    style="width:800px; text-align:center; margin:30px; background-color:#EAEAEA;">
                    <h4>{{$product->illustration_title}}</h4>
                </div>
                <div class="introduce" name="introduction_of_illustration"
                    style="width:800px; height:150px; margin:30px; background-color:#EAEAEA;">
                    <p>{{$product->introduction_of_illustration}}</p>
                    <div class="date" name="crated_at" style="float:right; margin-top:0px;">
                        <p>{{$product->updated_at}}</p>
                    </div>
                </div>
                <div class="tag" name="tag" style="width:800px; margin:30px; background-color:#EAEAEA;">
                    <p>{{$product->moreTag}}</p>
                </div>
                <div class="price" name="price_of_illustration"
                    style="width:800px; margin:30px; background-color:#EAEAEA;">
                    <p>{{$product->price_of_illustration}} <input type="button" value="구매"></p>
                </div>
                <div class="" name="" style="width:800px; margin:30px; background-color:#EAEAEA;s">
                    <button type="button" style="margin:10px;"><img src="{{asset('image/store/view.png')}}"
                            style="width:40px; height:40px;">
                        <button type="button" style="margin:10px;"><img src="{{asset('image/store/hand.png')}}"
                                style="width:40px; height:40px;">
                            <button type="button" style="margin:10px;"><img src="{{asset('image/store/like.png')}}"
                                    style="width:40px; height:40px;">
                                <button type="button" style="margin:10px;"><img src="{{asset('image/store/share.png')}}"
                                        style="width:40px; height:40px;">
                                    <button type="button" style="margin:10px;"><img
                                            src="{{asset('image/store/warning.png')}}" style="width:40px; height:40px;">
                </div>
                <hr style="width:850px;">


                <div class="container">
                    <div class="row">
                        <div class="col-sm-10 col-sm-offset-1" id="logout">
                            <div class="page-header">
                                <h3 class="reviews">Leave your comment</h3>
                            </div>
                            <div class="comment-tabs" style="width:800px;">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="active"><a href="#comments-logout" role="tab" data-toggle="tab">
                                            <h4 class="reviews text-capitalize">Comments</h4>
                                        </a></li>
                                    <li><a href="#add-comment" role="tab" data-toggle="tab">
                                            <h4 class="reviews text-capitalize">Add comment</h4>
                                        </a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="comments-logout">
                                        <ul class="media-list">
                                            <li class="media">
                                                <a class="pull-left" href="#">
                                                    <img class="media-object img-circle"
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
                                                            이 편지는 영국에서 최초로 시작되어 일년에 한 바퀴 돌면서행운을 주었고 당신에게로 옮겨진 이 편지는 4일
                                                            안에 당신 곁을 떠나야 합니다. 7통을 행운이 필요한 사람에게 보내 주셔야 합니다. 영국에서
                                                            HGXWCH이라는 사람은 1930년에 이 편지를 받았습니다. 그는 비서에게 복사해서 보내라고 했습니다. 며칠
                                                            뒤에 복권이 당첨되어 20억을 받았습니다. 미국의 케네디 대통령은 이 편지를 받았지만 그냥 버렸습니다. 결국
                                                            9일 후 그는 암살 당했습니다. 이 편지를 받은 사람은 행운이 깃들 것입니다. 7년의 행운을 빌면서..
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
                                                            class="glyphicon glyphicon-send"></span> Summit
                                                        comment</button>
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

            <div id="myModal" class="modal">
                <span class="close cursor" onclick="closeModal()">&times;</span>
                <div class="modal-content">
                    <div id="row">

                        <!-- 상세보기 일러스트 -->
                        <div class="mySlides">
                            <div class="numbertext">1 / 4</div>
                            <img src="{{asset('image/store/product-1.png')}}">
                        </div>

                        <div class="mySlides">
                            <div class="numbertext">2 / 4</div>
                            <img src="{{asset('image/store/product-2.png')}}">
                        </div>

                        <div class="mySlides">
                            <div class="numbertext">3 / 4</div>
                            <img src="{{asset('image/store/product-3.png')}}">
                        </div>

                        <div class="mySlides">
                            <div class="numbertext">4 / 4</div>
                            <img src="{{asset('image/store/product-4.png')}}">
                        </div>

                        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                        <a class="next" onclick="plusSlides(1)">&#10095;</a>

                        <div class="caption-container">
                            <p id="caption"></p>
                        </div>

                        <!-- 그 외 일러스트 -->
                        <div class="column">
                            <img class="demo cursor" src="{{asset('image/store/product-1.png')}}" style="width:100%"
                                onclick="currentSlide(1)" alt="Nature and sunrise">
                        </div>
                        <div class="column">
                            <img class="demo cursor" src="{{asset('image/store/product-2.png')}}" style="width:100%"
                                onclick="currentSlide(2)" alt="Snow">
                        </div>
                        <div class="column">
                            <img class="demo cursor" src="{{asset('image/store/product-3.png')}}" style="width:100%"
                                onclick="currentSlide(3)" alt="Mountains and fjords">
                        </div>
                        <div class="column">
                            <img class="demo cursor" src="{{asset('image/store/product-4.png')}}" style="width:100%"
                                onclick="currentSlide(4)" alt="Northern Lights">
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
