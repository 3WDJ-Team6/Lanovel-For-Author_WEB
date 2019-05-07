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

<<<<<<< HEAD
    <!-- ##### Right Side Cart Area ##### -->
    <div class="cart-bg-overlay"></div>

    <div id="invite" class="modal"></div>
    <div class="right-side-cart-area">

        <!-- Cart Button -->
        <div class="cart-button">
            <a href="#" id="rightSideCart"><img src="{{asset('image/store/bag.svg')}}" alt=""> <span>3</span></a>
        </div>

        <div class="cart-content d-flex">

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
        </div>
    </div>
    <!-- ##### Right Side Cart End ##### -->

=======
>>>>>>> b17c5a58a753c749f1b3861c03da3d59d4f8e673
    <!-- 새작품 -->

    <section class="welcome_area bg-img background-overlay" style="height:500px; margin-top:70px; background-image:url('image/store/girl.jpg');">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="hero-content">
                        <br>
                        <h2>New Collection</h2>
                        <a href="{{url('/newCollection')}}" class="btn essence-btn">view collection</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- 새작품 End -->

    <!-- 인기작품 -->
    <section class="new_arrivals_area section-padding-80 clearfix">
        <div class="container">
            <div class="row" div class="col-12">
                <div class="section-heading text-center">
                    <h2>Popular Products</h2>
                </div>
            </div>
        </div>
        </div>

        <!-- <div class="container"> -->
        <div class="row" style="margin-left:30px;">
            <div class="col-12">
                <div class="popular-products-slides owl-carousel">

                    @foreach ($products as $row)
                    <!-- Single Product -->
                    <div class="single-product-wrapper" style="display:inline-block; margin:40px;">
                        <div class="single-product">
                            <!-- Product Image -->
                            <div class="product-img" style="width: 250px; height: 150px; overflow: hidden;">
                                <a href="{{url('/view')}}/{{$row['num']}}">
                                    <img src="{{$row->url_of_illustration}}" alt="" onerror="this.src='{{asset('image/no_image.png')}}'">

                                    <!-- Hover Thumb -->
                                    <img class="hover-img" src="{{$row->url_of_illustration}}" alt="">
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
                                    <div class="add-to-cart-btn">
                                        <a href="{{url('/addCart')}}/{{$row->num}}" class="btn essence-btn">Add to
                                            Cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- </div> -->
        </section>
    <!-- 인기작품 End -->

</body>

@endsection

@section('footer')
@include('layouts.store.footer')
@endsection
