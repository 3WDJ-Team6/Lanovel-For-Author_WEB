@extends('layouts.store.master')

@section('head')
@include('layouts.store.head')
@endsection

@section('header')
@include('layouts.store.header')
@endsection

@section('content')

<body>

<section class="new_arrivals_area section-padding-80 clearfix">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading text-center">
                        <h2>Products</h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="container"> -->

        <div class="row" style="margin-left:100px;">
            <!-- <div class="col-12" > -->
            @foreach($products as $row)
            <!-- 작품 -->
            <a href="{{url('/view')}}/{{$row['num']}}">
                <div class="single-product-wrapper" style="display:inline-block; margin:40px;">
                    <!-- 작품이미지 --> p
                    <div class="product-img" style="width: 200px; height: 150px; overflow: hidden;">
                        <img src="{{$row['url_of_illustration']}}" alt="작품1" style="max-width: 300px; height: auto;">
                        <div class="product-favourite">
                            <a href="#" class="favme fa fa-heart"></a>
                        </div>
                    </div>
                    <!-- 작품설명 -->
                    <div class="product-description">
                        {{$row->user_id}}
                        <a href="single-product-details.html">
                            <h6>{{$row->illustration_title}}</h6>
                        </a>
                        <p class="product-price">{{$row->price_of_illustration}}</p>

                        <!-- 마우스 -->
                        <div class="hover-content">
                            <!-- 장바구니 -->
                            <div class="add-to-cart-btn">
                                <a href="#" class="btn essence-btn" style="width:100px;">Add to Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
            <!-- </div> -->
            </div>
        </div>

        <!-- </div> -->
    </section>

</body>

@endsection

@section('footer')
@include('layouts.store.footer')
<script src="{{asset('js/store/popper.min.js')}}"></script>
@endsection
