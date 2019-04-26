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
        <h2 style="text-align:center; color:black;">View</h2>
            <!-- 전부 -->
            <div class="row col-12 align-items: center; display: flex; justify-content: center;">
                <!-- <div class="col-12"> -->

                    <!-- 사진칸 -->
                    <div class="form-group">
                        <!-- 왼쪽 -->
                            <img src="{{$row->url_of_illustration}}" style="max-width: 100%; height: auto;" onclick="openModal();currentSlide(1)"
                                class="hover-shadow cursor">
                    </div>
                    <!-- 오른쪽 -->
                    <div class="form-group col-8">
                        <div class="title" name="illustration_title" style="width:100%; text-align:center; margin:30px; background-color:lightgray;">
                            <h4>{{$row->illustration_title}}</h4>
                        </div>
                        <div class="date" name="crated_at" style="float:right;">
                            <p>{{$row->updated_at}}</p>
                        </div>
                        <div class="introduce" name="introduction_of_illustration" style="width:100%; height:150px; margin:30px; background-color:lightgray;">
                            <p>{{$row->introduction_of_illustration}}</p>
                        </div>
                        <div class="tag" name="tag" style="width:100%; margin:30px; background-color:lightgray;">
                            <p>{{$row->moreTag}}</p>
                        </div>
                        <div class="price" name="price_of_illustration" style="width:100%; margin:30px; background-color:lightgray;">
                            <p>{{$row->price_of_illustration}} <input type="button" value="구매"></p>
                        </div>
                        <div class="" name="" style="width:100%; margin:30px; background-color:lightgray;">
                            <button type="button" style="margin:10px;"><img src="{{asset('image/store/view.png')}}" style="width:40px; height:40px;">
                            <button type="button" style="margin:10px;"><img src="{{asset('image/store/hand.png')}}" style="width:40px; height:40px;">
                            <button type="button" style="margin:10px;"><img src="{{asset('image/store/like.png')}}" style="width:40px; height:40px;">
                            <button type="button" style="margin:10px;"><img src="{{asset('image/store/share.png')}}" style="width:40px; height:40px;">
                            <button type="button" style="margin:10px;"><img src="{{asset('image/store/warning.png')}}" style="width:40px; height:40px;">
                        </div>
                    <hr style="width:100%;">
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

@section('footer')
@include('layouts.store.footer')
@endsection

