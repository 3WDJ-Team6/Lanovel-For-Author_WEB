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
@endsection

@section('header')
@include('layouts.store.header')
@endsection

@section('content')

<body>

    <section class="new_arrivals_area" style="width:100%">
        <h2 style="text-align:center">My page</h2>
        <!-- 전부 -->
        <div class="row" style="justify-content:center; width:100%;">
            <!-- <div class="col-12"> -->

            <!-- 왼쪽 -->
            <div class="form-group" id="left">
                <div class="form-group" id="left-top">
                    <div class="form-group" id="profile-photo">
                        <img src="{{asset('image/store/product-1.png')}}"
                            style="margin-top:50px; position: relative; background:center no-repeat; border-radius: 50%; width: 150px; height: 150px; ">
                    </div>
                    <div class="form-group" id="nickname">
                        sunsilver
                    </div>
                    <div class="form-group" id="ninckname">
                        <p>그림 외주, 협업 다 받아요~</p><button type="submit" style="width:100px;">수정</button>
                    </div>
                </div>
                <div class="form-group" id="left-bottom">
                    <p>1000p</p><button type="submit" style="width:100px;">충전</button>
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
                            <div class="form-group" id="img">
                                <img src="{{asset('image/store/product-5.png')}}" style="width: 150px; height: 150px;">
                            </div>
                            <div class="form-group" id="img">
                                <img src="{{asset('image/store/product-5.png')}}" style="width: 150px; height: 150px;">
                            </div>
                            <div class="form-group" id="img">
                                <img src="{{asset('image/store/product-5.png')}}" style="width: 150px; height: 150px;">
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile-tabs-above" role="tabpanel"
                            aria-labelledby="profile-tabs-above">
                            <div class="form-group" style="">
                                <div id="chartdiv"></div>
                            </div>
                        </div>
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
                            <p>channel_on: 그림 너무 좋아요~</p>
                        </div>
                        <div class="tab-pane fade" id="like-tabs-above" role="tabpanel"
                            aria-labelledby="dropdown-tab-tabs-above-2">
                            <div class="form-group" id="img">
                                <img src="{{asset('image/store/product-5.png')}}" style="width: 150px; height: 150px;">
                                like
                            </div>
                        </div>
                        <div class="tab-pane fade" id="cart-tabs-above" role="tabpanel"
                            aria-labelledby="dropdown-tab-tabs-above-2">
                            <div class="form-group" id="img">
                                <img src="{{asset('image/store/product-5.png')}}" style="width: 150px; height: 150px;">
                                cart
                            </div>
                        </div>
                        <div class="tab-pane fade" id="buy-tabs-above" role="tabpanel"
                            aria-labelledby="dropdown-tab-tabs-above-2">
                            <div class="form-group" id="img">
                                <img src="{{asset('image/store/product-5.png')}}" style="width: 150px; height: 150px;">
                                buy
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
