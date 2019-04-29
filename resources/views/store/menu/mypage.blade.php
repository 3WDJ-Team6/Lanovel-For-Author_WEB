@extends('layouts.store.master')

@section('head')
@include('layouts.store.head')
<style>
    #chartdiv {
        width: 100%;
        height: 500px;
    }

</style>

<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/frozen.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
<script src="{{asset('js/store/mypage_graph.js')}}" defer></script>
<link rel="stylesheet" href="{{asset('css/store/mypage.css')}}">
<link rel="stylesheet" href="{{asset('css/store/mypage_chat.css')}}">
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
            <!-- <div class="col-12"> -->

            <!-- 왼쪽 -->
            <div class="form-group" id="left">
                <div class="form-group" id="left-top">
                    <div class="form-group" id="profile-photo">
                        <img src="{{asset('image/store/product-1.png')}}">
                    </div>
                    <div class="form-group" id="nickname">
                        <p>{{$row->nickname}}</p>
                    </div>
                    <div class="form-group" id="ninckname">
                        <p>{{$row->introduction_message}}</p><button type="submit" style="width:100px;">수정</button>
                    </div>
                </div>
                <div class="form-group" id="left-bottom">
                    <p>{{$row->point}}</p><button type="submit" style="width:100px;">충전</button>
                </div>
            </div>
            <!-- 오른쪽 -->
            <div class="form-group" style="display:inline-block">
                <div class='tabs-x tabs-above tab-bordered tabs-krajee' id="right">
                    <ul id="myTab-tabs-above" class="nav nav-tabs" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="home" href="#home-tabs-above" role="tab"
                                data-toggle="tab" data-url="/site/fetch-tab?tab=1" aria-controls="home"
                                aria-expanded="true"><i class="fa fa-home"></i> 내작품</a></li>

                        <li class="nav-item"><a class="nav-link" id="profile" href="#profile-tabs-above" role="tab"
                                data-toggle="tab" data-url="/site/fetch-tab?tab=2" aria-controls="profile"><i
                                    class="fa fa-user"></i>
                                수익정산</a></li>

                        <li class="nav-item"><a class="nav-link" id="follow" href="#follow-tabs-above" role="tab"
                                data-toggle="tab" data-url="/site/fetch-tab?tab=2" aria-controls="profile"><i
                                    class="fa fa-user"></i>
                                팔로우</a></li>
                        <li class="nav-item"><a class="nav-link" id="message" href="#message-tabs-above" role="tab"
                                data-toggle="tab" data-url="/site/fetch-tab?tab=2" aria-controls="profile"><i
                                    class="fa fa-user"></i>
                                메시지</a></li>
                        <li class="nav-item"><a class="nav-link" id="like" href="#like-tabs-above" role="tab"
                                data-toggle="tab" data-url="/site/fetch-tab?tab=2" aria-controls="profile"><i
                                    class="fa fa-user"></i>
                                좋아요</a></li>
                        <li class="nav-item"><a class="nav-link" id="cart" href="#cart-tabs-above" role="tab"
                                data-toggle="tab" data-url="/site/fetch-tab?tab=2" aria-controls="profile"><i
                                    class="fa fa-user"></i>
                                장바구니</a></li>
                        <li class="nav-item"><a class="nav-link" id="buy" href="#buy-tabs-above" role="tab"
                                data-toggle="tab" data-url="/site/fetch-tab?tab=2" aria-controls="profile"><i
                                    class="fa fa-user"></i>
                                구입</a></li>
                    </ul>
                    <div id="myTabContent-tabs-above" class="tab-content" style="width:100%">
                        <div class="tab-pane fade show active" id="home-tabs-above" role="tabpanel"
                            aria-labelledby="home-tab-tabs-above">
                            @foreach($products as $product)
                            <div class="form-group" id="img">
                                <img src="{{$product->url_of_illustration}}" style="width: 150px; height: 150px;">
                                <div class="form-group">
                                    <p>{{$product->illustration_title}}</p>
                                    <p>{{$product->create_at}}</P>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <!-- 수익 그래프 -->
                        <div class="tab-pane fade" id="profile-tabs-above" role="tabpanel"
                            aria-labelledby="profile-tabs-above">
                            <div class="form-group" style="">
                                <div id="chartdiv"></div>
                            </div>
                        </div>

                        <script>
                            console.log("읽힘 성공성공");

                        </script>

                        <!-- 팔로잉 -->
                        <div class="tab-pane fade" id="follow-tabs-above" role="tabpanel"
                            aria-labelledby="dropdown-tab-tabs-above-1">
                            <div class="form-group" style="display:inline-block; float:left; width:400px;">
                                <div class="form-group">팔로우</div>
                                <div>
                                    <div id="follow_profile"><img src="{{asset('image/store/product-5.png')}}"></div>
                                    <div id="follow_id">channel_on</div>
                                </div>
                                <div>
                                    <div id="follow_profile"><img src="{{asset('image/store/product-5.png')}}"></div>
                                    <div id="follow_id">channel_on</div>
                                </div>
                                <div>
                                    <div id="follow_profile"><img src="{{asset('image/store/product-5.png')}}"></div>
                                    <div id="follow_id">channel_on</div>
                                </div>
                            </div>
                            <div class="form-group" style="display:inline-block; float:left; width:400px;">
                                <div class="form-group">팔로워</div>
                                <div>
                                    <div id="follow_profile"><img src="{{asset('image/store/product-6.png')}}"></div>
                                    <div id="follow_id">hongki_95</div>
                                </div>
                                <div>
                                    <div id="follow_profile"><img src="{{asset('image/store/product-6.png')}}"></div>
                                    <div id="follow_id">hongki_95</div>
                                </div>
                                <div>
                                    <div id="follow_profile"><img src="{{asset('image/store/product-6.png')}}"></div>
                                    <div id="follow_id">hongki_95</div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="message-tabs-above" role="tabpanel"
                            aria-labelledby="dropdown-tab-tabs-above-2">
                            <div class="container">
                                <div class="wrapper wrapper-content animated fadeInRight">

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="ibox chat-view">
                                                <div class="ibox-title">
                                                    <small class="pull-right text-muted">Last message: Mon Jan 26 2015 -
                                                        18:39:23</small> Chat room panel
                                                </div>
                                                <div class="ibox-content">
                                                    <div class="row">
                                                        <div class="col-md-9 ">
                                                            <div class="chat-discussion">

                                                                <div class="chat-message left">
                                                                    <img class="message-avatar"
                                                                        src="https://bootdey.com/img/Content/avatar/avatar1.png"
                                                                        alt="">
                                                                    <div class="message">
                                                                        <a class="message-author" href="#"> Michael
                                                                            Smith </a>
                                                                        <span class="message-date"> Mon Jan 26 2015 -
                                                                            18:39:23 </span>
                                                                        <span class="message-content">
                                                                            Lorem ipsum dolor sit amet, consectetuer
                                                                            adipiscing elit, sed diam nonummy nibh
                                                                            euismod tincidunt ut laoreet dolore magna
                                                                            aliquam erat volutpat.
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="chat-message right">
                                                                    <img class="message-avatar"
                                                                        src="https://bootdey.com/img/Content/avatar/avatar6.png"
                                                                        alt="">
                                                                    <div class="message">
                                                                        <a class="message-author" href="#"> Karl Jordan
                                                                        </a>
                                                                        <span class="message-date"> Fri Jan 25 2015 -
                                                                            11:12:36 </span>
                                                                        <span class="message-content">
                                                                            Many desktop publishing packages and web
                                                                            page editors now use Lorem Ipsum as their
                                                                            default model text, and a search for 'lorem
                                                                            ipsum' will uncover.
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="chat-message right">
                                                                    <img class="message-avatar"
                                                                        src="https://bootdey.com/img/Content/avatar/avatar6.png"
                                                                        alt="">
                                                                    <div class="message">
                                                                        <a class="message-author" href="#"> Michael
                                                                            Smith </a>
                                                                        <span class="message-date"> Fri Jan 25 2015 -
                                                                            11:12:36 </span>
                                                                        <span class="message-content">
                                                                            There are many variations of passages of
                                                                            Lorem Ipsum available, but the majority have
                                                                            suffered alteration.
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="chat-message left">
                                                                    <img class="message-avatar"
                                                                        src="https://bootdey.com/img/Content/avatar/avatar1.png"
                                                                        alt="">
                                                                    <div class="message">
                                                                        <a class="message-author" href="#"> Alice Jordan
                                                                        </a>
                                                                        <span class="message-date"> Fri Jan 25 2015 -
                                                                            11:12:36 </span>
                                                                        <span class="message-content">
                                                                            All the Lorem Ipsum generators on the
                                                                            Internet tend to repeat predefined chunks as
                                                                            necessary, making this the first true
                                                                            generator on the Internet.
                                                                            It uses a dictionary of over 200 Latin
                                                                            words.
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="chat-message right">
                                                                    <img class="message-avatar"
                                                                        src="https://bootdey.com/img/Content/avatar/avatar6.png"
                                                                        alt="">
                                                                    <div class="message">
                                                                        <a class="message-author" href="#"> Mark Smith
                                                                        </a>
                                                                        <span class="message-date"> Fri Jan 25 2015 -
                                                                            11:12:36 </span>
                                                                        <span class="message-content">
                                                                            All the Lorem Ipsum generators on the
                                                                            Internet tend to repeat predefined chunks as
                                                                            necessary, making this the first true
                                                                            generator on the Internet.
                                                                            It uses a dictionary of over 200 Latin
                                                                            words.
                                                                        </span>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="chat-users">


                                                                <div class="users-list">
                                                                    <div class="chat-user">
                                                                        <img class="chat-avatar"
                                                                            src="https://bootdey.com/img/Content/avatar/avatar1.png"
                                                                            alt="">
                                                                        <div class="chat-user-name">
                                                                            <a href="#">Karl Jordan</a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="chat-user">
                                                                        <img class="chat-avatar"
                                                                            src="https://bootdey.com/img/Content/avatar/avatar2.png"
                                                                            alt="">
                                                                        <div class="chat-user-name">
                                                                            <a href="#">Monica Smith</a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="chat-user">
                                                                        <span
                                                                            class="pull-right label label-primary">Online</span>
                                                                        <img class="chat-avatar"
                                                                            src="https://bootdey.com/img/Content/avatar/avatar3.png"
                                                                            alt="">
                                                                        <div class="chat-user-name">
                                                                            <a href="#">Michael Smith</a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="chat-user">
                                                                        <span
                                                                            class="pull-right label label-primary">Online</span>
                                                                        <img class="chat-avatar"
                                                                            src="https://bootdey.com/img/Content/avatar/avatar4.png"
                                                                            alt="">
                                                                        <div class="chat-user-name">
                                                                            <a href="#">Janet Smith</a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="chat-user">
                                                                        <img class="chat-avatar"
                                                                            src="https://bootdey.com/img/Content/avatar/avatar5.png"
                                                                            alt="">
                                                                        <div class="chat-user-name">
                                                                            <a href="#">Alice Smith</a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="chat-user">
                                                                        <img class="chat-avatar"
                                                                            src="https://bootdey.com/img/Content/avatar/avatar6.png"
                                                                            alt="">
                                                                        <div class="chat-user-name">
                                                                            <a href="#">Monica Cale</a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="chat-user">
                                                                        <img class="chat-avatar"
                                                                            src="https://bootdey.com/img/Content/avatar/avatar7.png"
                                                                            alt="">
                                                                        <div class="chat-user-name">
                                                                            <a href="#">Mark Jordan</a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="chat-user">
                                                                        <span
                                                                            class="pull-right label label-primary">Online</span>
                                                                        <img class="chat-avatar"
                                                                            src="https://bootdey.com/img/Content/avatar/avatar8.png"
                                                                            alt="">
                                                                        <div class="chat-user-name">
                                                                            <a href="#">Janet Smith</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="chat-message-form">
                                                                <div class="form-group">
                                                                    <textarea class="form-control message-input"
                                                                        name="message"
                                                                        placeholder="Enter message text and press enter"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="like-tabs-above" role="tabpanel"
                            aria-labelledby="dropdown-tab-tabs-above-2">
                            @foreach($likeProducts as $product)
                            <div class="form-group" id="img">
                                <img src="{{$product->url_of_illustration}}" style="width: 150px; height: 150px;">
                                <div class="form-group">
                                    <p>{{$product->illustration_title}}</p>
                                    <p>{{$product->create_at}}</P>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="tab-pane fade" id="cart-tabs-above" role="tabpanel"
                            aria-labelledby="dropdown-tab-tabs-above-2">
                            <div class="form-group" id="img">
                                <img src="{{$row->url_of_illustration}}" style="width: 150px; height: 150px;">
                                <div class="form-group">
                                    <p>{{$row->illustration_title}}</p>
                                    <p>{{$row->create_at}}</P>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="buy-tabs-above" role="tabpanel"
                            aria-labelledby="dropdown-tab-tabs-above-2">
                            <div class="form-group" id="img">
                                <img src="{{$row->url_of_illustration}}" style="width: 150px; height: 150px;">
                                <div class="form-group">
                                    <p>{{$row->illustration_title}}</p>
                                    <p>{{$row->create_at}}</P>
                                </div>
                            </div>
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
