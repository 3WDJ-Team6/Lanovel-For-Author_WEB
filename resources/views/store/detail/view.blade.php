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

    .main_image {
        width: 110%;
        height: 110%;
        cursor: pointer;
        position: absolute;
        display: inline-block;
        object-fit: cover;
        box-shadow: 15px 10px 20px -6px;
        right: 10%;
    }

    .main_image::after {
        position: absolute;
        display: block;
        content: "";
        top: 110px;
        left: 0px;
        width: 90%;
        height: 81.7%;
        background-repeat: no-repeat;
        background-position: top left, top right;
        background: linear-gradient(41deg, #fff 119px, rgba(0, 0, 0, 0) 120px);
    }

    .main_image_img {
        width: 100%;
        height: 100%;
    }

    .main-form {
        width: 100%;
        height: 100%;
        margin-top: 25%;
    }

    .main_illust {
        position: relative;
        background-color: #ffffff70;
        margin-top: 40%;
    }

    .left_group {
        margin-top: 9%;
        margin-left: 10%;
        display: inline-block;
        width: 45%;
        height: 400px;
        position: relative;
    }

    .right_group {
        display: inline-block;
        width: 450px;
        position: absolute;
        top: 21%;
        margin-left: 1%;
    }

    .btn {
        padding: 0;
        padding-right: 8px;
    }

    .btnSubmit {
        border-radius: 3px;
        border: 0;
        background-color: #ea5254;
        color: white;
        width: 120px;
        height: 40px;
    }

    .holine {
        width: 90%;
        top: 32%;
        left: 4%;
        border: 1px solid #d8d8d8;
        position: absolute;
        margin: 0;
    }

    .logo {
        padding-bottom: 10px;
        width: 30px;
        height: 50px;
        margin-left: 7%;
    }

    .btn_list {
        margin-left: 54%;
    }

    .list_title {
        margin-top: 3%;
    }

    .form-control {
        width: 476px;
        margin-top: 9%;
    }

    .closed {
        position: absolute;
        top: 9%;
        right: 7%;
        display: block;
        width: 40px;
        height: 40px;
    }

    .modal-content {
        width: 120%;
        height: 230px;
    }

    .logo_moji {
        position: absolute;
        font-size: 30px;
        top: 9%;
    }

    .bo {
        margin-left: 4%;
        font-size: 24px;
        margin-right: 6%;
        text-align: center;
        margin-top: 2%;
        margin-bottom: 5%;
        border: 2px solid #d8d8d8;
    }
    ::-webkit-scrollbar {
        display: none;
    }
</style>



@endsection

@section('header')
@include('layouts.store.header')
@endsection

@section('content')

<body>

    <div class="container_box" style="    overflow-y: hidden;">
        <div class="background" style="position: absolute; z-index:-1; left:16%; top: 7.7%;">
            <img src="{{asset('image/store/illust_view_background.png')}}" style="width:110%; margin-left: -4%;">
        </div>
        <!-- 왼쪽 -->
        <div class="form-group left_group">

            <!-- 메인사진 -->
            <div class="main-form">
                <div class="main_image">
                    <img class="main_image_img" src="{{$product->url_of_illustration}}"
                        onclick="openModal();currentDiv(1)">
                </div>
                <img class="main_illust" src="{{asset('image/store/illustore2.png')}}">
            </div>
            <!-- 서브사진 -->
            <div class="form-group">

                <div class="form-group" style=" height:90px; cursor:pointer; margin-top:30px; margin-left:-10px;">
                    @foreach($posts as $post)
                    <img src="{{$post->url_of_illustration}}" class="w3-hover-shadow"
                        onclick="openModal();currentDiv(1)"
                        style="width:70px; height:70px; margin:10px; display:inline-block;opacity: 0;">
                    @endforeach
                </div>
            </div>
        </div>

        <!-- 오른쪽 -->
        <div class="form-group right_group">
            {{-- <div class="form-group" style=""> --}}
            <div class="top_form">
                <!-- 제목 -->
                <div class="form-group" style="width:100%;">
                    <div class="title" name="illustration_title" style="width:350px;display:inline-block;">
                        <h3>{{$product->illustration_title}}</h3>
                    </div>
                    <div class="nickname" name="nickname" style="width:100%;text-align:left;">
                        <p>by.&nbsp;{{$product->nickname}}</p>
                    </div>
                    <img src="{{asset('image/color_bar.png')}}" style="margin-bottom: 26%;">
                </div>
                <!-- 작품설명 -->
                <div class="introduce" name="introduction_of_illustration" style="width:100%;font-size:130%;">
                    <div style="font-weight:bold;">作品説明 </div>
                    {{$product->introduction_of_illustration}}
                </div>
                <!-- 태그/가격/시간 -->
                <div class="tag" name="tag" style="width:100%; height:30px; display:inline-block; font-size: 130%;">
                    <span style="font-weight:bold">タグ</span>
                    @foreach($tags as $tag)
                    <span class="badge badge-light">#{{$tag->moreTag}}
                    </span>

                    @endforeach
                </div>
                <div class="price" name="price_of_illustration"
                    style="width:260px; margin-left: -40%;margin:20px; text-align:right; display:inline-block; font-size: 130%;">
                    <span style="font-weight:bold; float: left; margin-left: -6%;">価格</span> <span
                        style="float: left; margin-left:5%;">{{$product->price_of_illustration}}</span>
                </div>

                <div class="date" name="crated_at" style="margin-top:0px;font-size: 130%;margin-bottom: 3%;">
                        <span style="font-weight:bold;">アップロード</span> {{$product->created_ata}}
                </div>

                <span style="width:200px;margin-left:76%;">
                    <button type="button" class="btn" data-toggle="modal" data-target="#alarmModal">
                        <img src="{{asset('image/store/illust_cart.png')}}">
                    </button>
                    <button type="button" class="btn" data-toggle="modal" data-target="#alarmModal">
                        <img src="{{asset('image/store/illust_buy.png')}}">
                    </button>
                    <button type="button" class="btn">
                        <img src="{{asset('image/like_icon.png')}}">
                    </button>
                </span>

                <!-- Modal -->
                <div class="modal fade" id="alarmModal" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <h3 class='list_title'>
                                <img src='../../../image/logo_book.png' class='logo'>
                                <b class="logo_moji" style='position:absolute;'>&nbsp;購入</b>
                                <img src='../svg/closed_icon.svg' class="closed">
                            </h3>
                            <hr class="holine">
                            <div class="bo">このイラストを<b>購入</b>しますか？</div>
                            <div class="btn_list">
                                <button type="button" class="btnSubmit" data-dismiss="modal">キャンセル</button>
                                <button type="button" class="btnSubmit"　onclick="location.href='{{url('/buyIllust')}}/{{$product->num}}'">購入</button>
                            </div>
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
                    <img class="mySlides" src="{{$post->url_of_illustration}}" style="width:1000px; height:400px;">
                    @endforeach
                    <div class="w3-row w3-black w3-center">
                        <div class="w3-display-container">
                            <p id="caption"></p>
                            <span class="w3-display-left w3-btn" onclick="plusDivs(-1)">❮</span>
                            <span class="w3-display-right w3-btn" onclick="plusDivs(1)">❯</span>
                        </div>
                        @foreach($posts as $post)
                        <div class="w3-col s4" style="width:225px; height:150px;">
                            <img class="demo w3-opacity w3-hover-opacity-off" src="{{$post->url_of_illustration}}"
                                onclick="currentDiv(1)" alt="Nature and sunrise" style="width:225px; height:150px;">
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
