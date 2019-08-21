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

    <div class="container_box">
        <div class="background" style="position: absolute; z-index:-1; left:16%; top: 7.7%;">
            <img src="{{asset('image/store/illust_view_background.png')}}" style="width:110%; margin-left: -4%;">
        </div>
        <!-- 왼쪽 -->
        <div class="form-group"
            style="margin:5%; margin-top:13%; display:inline-block; width:400px; position:relative;">

            <!-- 메인사진 -->
            <div class="main-form" style="width: 400px; height: 400px; ">
                <img src="{{$product->url_of_illustration}}"
                    style="width: 400px; height: 400px; cursor:pointer; position: absolute; display:inline-block; object-fit:cover;"
                    onclick="openModal();currentDiv(1)" class="w3-hover-shadow">
                <img src="{{asset('image/store/illustore2.png')}}"
                    style="position: relative; margin-left:23px; margin-top:160px;">
            </div>
            <!-- 서브사진 -->
            <div class="form-group">

                <div class="form-group" style=" height:90px; cursor:pointer; margin-top:30px; margin-left:-10px;">
                    @foreach($posts as $post)
                    <img src="{{$post->url_of_illustration}}" class="w3-hover-shadow"
                        onclick="openModal();currentDiv(1)"
                        style="width:70px; height:70px; margin:10px; display:inline-block;">
                    @endforeach
                </div>
            </div>
        </div>

        <!-- 오른쪽 -->
        <div class="form-group" style="margin: 6%; display: inline-block; width: 400px; position:relative;">
            <div class="form-group" style="">

                <div class="top_form">
                    <!-- 제목 -->
                    <div class="form-group" style="width:100%;     height: 200px">
                        <div class="title" name="illustration_title" style="width:350px; margin:20px; margin-left:0; display:inline-block;">
                            <h3>{{$product->illustration_title}}</h3>
                        </div>
                        <div class="nickname" name="nickname" style="width:100%; text-align:center; margin:10px;text-align:left;">
                <p>{{$product->nickname}}</p>
            </div>
                        <img src="{{asset('image/color_bar.png')}}" style="margin-bottom: 26%;">


                    </div>
                    <!-- 작품설명 -->
                    <div class="introduce" name="introduction_of_illustration" style="width:100%; height:50px; font-size: 130%;">
                        <span style="font-weight:bold;">作品説明 </span> 
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
                    <div class="price" name="price_of_illustration" style="width:260px; margin-left: -40%;margin:20px; text-align:right; display:inline-block; font-size: 130%;">
                    <span style="font-weight:bold; float: left; margin-left: -6%;">価格</span> <span style="float: left; margin-left:5%;">{{$product->price_of_illustration}}</span>
                    </div>
                   
                    <span class="date" name="crated_at" style=" margin-top:0px; font-size: 130%; float:left;">
                    <span style="font-weight:bold;">アップロード</span> {{$product->updated_at}}
                    </span>

                    <span class="button">
                    <button type="button" class="btn btn-light" data-toggle="modal" data-target="#alarmModal" style="width:80px; margin-top: -40%; margin-left: 22%;">
                    <img src="{{asset('image/store/illust_cart.png')}}">
                    <img src="{{asset('image/store/illust_buy.png')}}">
                    </button>
                    </span>

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
                                    <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
                                    <button type="button"
                                        onclick="location.href='{{url('/buyIllust')}}/{{$product->num}}'"
                                        class="btn btn-primary">구매</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            




        </div>
        <div class="form-group" style=" text-align:right; height:50px;">
            <div class="" name="" style="width:400px; height:45px; margin:15px; display:inline-block;">
                <button type="button" class="btn btn-light btn-like" style="margin:10px; display:inline-block;"><img
                        src="{{asset('image/store/like.png')}}" style="width:30px; height:30px;"></button>
                <button type="button" class="btn btn-light" style="margin:10px;display:inline-block;"><img
                        src="{{asset('image/store/share.png')}}" style="width:30px; height:30px;"></button>
            </div>
        </div>

    </div>
    <hr style="width:710px;">


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
