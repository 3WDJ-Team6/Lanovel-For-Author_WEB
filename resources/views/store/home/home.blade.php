@extends('layouts.store.master')

@section('head')
    @include('layouts.store.head')
@endsection

@section('header')
    @include('layouts.store.header')
@endsection


@section('content')

<body>

    <!-- 새작품 -->
    <section class="welcome_area bg-img background-overlay" style="">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="hero-content">
                        <h6>asoss</h6>
                        <h2>New Collection</h2>
                        <a href="#" class="btn essence-btn">view collection</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- 새작품 End -->

    <!-- 인기작품 -->
    <section class="new_arrivals_area section-padding-80 clearfix">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading text-center">
                        <h2>Popular Products</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="popular-products-slides owl-carousel">

                        <!-- Single Product -->
                        <div class="single-product-wrapper">
                            <!-- Product Image -->
                            <div class="product-img">
                            <a href="{{url('store/detail/view')}}/{{$row['num']}}">
                                <img src="{{$row['position_of_illustration']}}" alt="">
                                <!-- Hover Thumb -->
                                <!-- <img class="hover-img" src="{{asset('image/store/product-1.png')}}" alt=""> -->
                                <!-- Favourite -->
                                <div class="product-favourite">
                                    <a href="#" class="favme fa fa-heart"></a>
                                </div>
                            </a>
                            </div>

                            <!-- Product Description -->
                            <div class="product-description">
                                {{$row->user_id}}
                                <a href="single-product-details.html">
                                    <h6>{{$row->illustration_title}}</h6>
                                </a>
                                <p class="product-price">{{$row->price_of_illustration}}</p>

                                <!-- Hover Content -->
                                <div class="hover-content">
                                    <!-- Add to Cart -->
                                    <div class="add-to-cart-btn">
                                        <a href="#" class="btn essence-btn">Add to Cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- 인기작품 End -->


</body>

@endsection

@section('footer')
@include('layouts.store.footer')
@endsection
