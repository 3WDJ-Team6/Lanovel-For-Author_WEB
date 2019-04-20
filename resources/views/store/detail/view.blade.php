@extends('layouts.store.master')

@section('head')
@include('layouts.store.head')
<script src="{{asset('js/store/detail_view_image.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/store/detail_view_image.css')}}">
@endsection

@section('header')
@include('layouts.store.header')
@endsection

@section('content')

<body>

    <section class="new_arrivals_area section-padding-80 clearfix">

        <div class="container">
        <h2 style="text-align:center">Lightbox</h2>
            <!-- 전부 -->
            <div class="row">
                <!-- <div class="col-12"> -->

                    <!-- 사진칸 -->
                    <div class="row">
                        <!-- 왼쪽 -->
                        <div class="column">
                            <img src="{{asset('image/store/product-1.png')}}" style="max-width: 100%; height: auto;" onclick="openModal();currentSlide(1)"
                                class="hover-shadow cursor">
                        </div>
                    </div>
                    <!-- 오른쪽 -->
                    <div class="row">
                        <div class="title">
                        <h4>총든 여자</h4>
                        </div>
                        <div class="introduce">
                        <p>백발의 여성이 총을 들고있는 구도를 그려봤어요</p>
                        </div>
                    </div>

                    <div id="myModal" class="modal">
                        <span class="close cursor" onclick="closeModal()">&times;</span>
                        <div class="modal-content">
                        <div id="row" >

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
        </div>
    </section>

</body>

@endsection
