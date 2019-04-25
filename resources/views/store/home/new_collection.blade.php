@extends('layouts.store.master')

@section('head')
@include('layouts.store.head')
@endsection

@section('header')
@include('layouts.store.header')
@endsection

@section('content')

<body>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="popular-products-slides owl-carousel">

                    <!-- Single Product -->
                    <div class="single-product-wrapper">
                        <div class="single-product">
                            <!-- Product Image -->
                            <div class="product-img">
                                <a href="{{url('store/detail/view')}}">
                                    <img src="" alt="" onerror="this.src='{{asset('image/no_image.png')}}'">
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

                                <a href="single-product-details.html">
                                </a>
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
    </div>
    </section>

</body>

@endsection

@section('footer')
@include('layouts.store.footer')
<script src="{{asset('js/store/popper.min.js')}}"></script>
@endsection
