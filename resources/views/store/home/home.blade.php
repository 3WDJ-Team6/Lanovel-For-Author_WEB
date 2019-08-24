@extends('layouts.store.master')

@section('head')
@include('layouts.store.head')

@endsection

@section('header')
@include('layouts.store.header')
@endsection

@section('content')

<body>
    @if(Session::has('success'))
    <div class="alert alert-info">{{ Session::get('success') }}</div>
    @endif
    <!-- ##### Right Side Cart Area ##### -->
    <div class="cart-bg-overlay"></div>

    <div id="invite" class="modal"></div>
    <div class="right-side-cart-area">

        <!-- Cart Button -->
        {{-- <div class="cart-button">
            <a href="#" id="rightSideCart"><img src="{{asset('image/store/bag.svg')}}" alt=""> <span>3</span></a>
        </div> --}}

        {{-- <div class="cart-content d-flex">

            <!-- Cart List Area -->
            <div class="cart-list">
                <!-- Single Cart Item -->
                <div class="single-cart-item">
                    <a href="#" class="product-image">
                        <img src="{{asset('image/store/product-1.png')}}" class="cart-thumb" alt="">
                        <!-- Cart Item Desc -->
                        <div class="cart-item-desc">
                            <span class="product-remove"><i class="fa fa-close" aria-hidden="true"></i></span>
                            <span class="badge">Mango</span>
                            <h6>Button Through Strap Mini Dress</h6>
                            <p class="size">Size: S</p>
                            <p class="color">Color: Red</p>
                            <p class="price">$45.00</p>
                        </div>
                    </a>
                </div>

                <!-- Single Cart Item -->
                <div class="single-cart-item">
                    <a href="#" class="product-image">
                        <img src="{{asset('image/store/product-1.png')}}" class="cart-thumb" alt="">
                        <!-- Cart Item Desc -->
                        <div class="cart-item-desc">
                            <span class="product-remove"><i class="fa fa-close" aria-hidden="true"></i></span>
                            <span class="badge">Mango</span>
                            <h6>Button Through Strap Mini Dress</h6>
                            <p class="size">Size: S</p>
                            <p class="color">Color: Red</p>
                            <p class="price">$45.00</p>
                        </div>
                    </a>
                </div>

                <!-- Single Cart Item -->
                <div class="single-cart-item">
                    <a href="#" class="product-image">
                        <img src="{{asset('image/store/product-1.png')}}" class="cart-thumb" alt="">
                        <!-- Cart Item Desc -->
                        <div class="cart-item-desc">
                            <span class="product-remove"><i class="fa fa-close" aria-hidden="true"></i></span>
                            <span class="badge">Mango</span>
                            <h6>Button Through Strap Mini Dress</h6>
                            <p class="size">Size: S</p>
                            <p class="color">Color: Red</p>
                            <p class="price">$45.00</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="cart-amount-summary">

                <h2>Summary</h2>
                <ul class="summary-table">
                    <li><span>subtotal:</span> <span>$274.00</span></li>
                    <li><span>delivery:</span> <span>Free</span></li>
                    <li><span>discount:</span> <span>-15%</span></li>
                    <li><span>total:</span> <span>$232.00</span></li>
                </ul>
                <div class="checkout-btn mt-100">
                    <a href="checkout.html" class="btn essence-btn">check out</a>
                </div>
            </div>
        </div> --}}
    </div>
    <!-- ##### Right Side Cart End ##### -->
    <div class="container_box">
    <div class="background" style="position: absolute; z-index:-1; left:16%; top: 7.7%;">
            <img src="{{asset('image/store/illust_background.png')}}" style="width:110%; margin-left: -4%; margin-top: 0%;">
    </div>
    <img src="{{asset('image/logo2.png')}}" style="    width: 710px; height:110px; margin-top: 19%; margin-left: 18%;">
            <img src="{{asset('image/store/illust_title_bg.png')}}"
                style="width:700px; height:20px; margin-top:2%; margin-left: 19%;">

        <!-- 인기작품 -->
        <section class="section-padding-80 clearfix">
            <div class="container " style="align-items: center; display: flex; justify-content: center;">
                <div class="row">
                    <div class="section-heading text-center" style="margin:70px;">
                    <img src="{{asset('image/store/illust_popular.png')}}">


                    </div>
                </div>
            </div>


            <div class="fomr-group" style="display:innline-block;">
                <div class="row">
                        @foreach ($products as $row)
                        <!-- Single Product -->
                        <div class="product_box">
                            <div class="single-product">
                                <!-- Product Image -->
                                <div class="product-img">
                                    <a href="{{url('/view')}}/{{$row['num']}}">
                                        <img src="{{$row->url_of_illustration}}" alt=""
                                            onerror="this.src='{{asset('image/no_image.png')}}'">

                                        <!-- Favourite -->
                                        <div class="product-favourite">
                                            <a href="{{url('/addLike')}}/{{$row->num}}" class="favme fa fa-heart"></a>
                                        </div>
                                    </a>
                                </div>

                                <!-- Product Description -->
                                <div class="product-description">
                                    {{ $row->nickname }}
                                    <a href="single-product-details.html">
                                        <h6>{{ $row->illustration_title }}</h6>
                                    </a>
                                    <p class="product-price">{{ $row->price_of_illustration }}</p>

                                    <!-- Hover Content -->
                                    <div class="hover-content">
                                        <!-- Add to Cart -->
                                        <div class="add-to-cart-btn" style="display:block; width:190px;">
                                            <a href="{{url('/addCart')}}/{{$row->num}}" class="btn essence-btn">Add to
                                                Cart</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    <!-- </div> -->
                </div>
            </div>
        </section>
    </div>

    <!-- 인기작품 End -->

</body>

@endsection

{{-- @section('footer')
@include('layouts.store.footer')
@endsection --}}
