@extends('layouts.store.master')

@section('head')
@include('layouts.store.head')
@endsection

@section('header')
@include('layouts.store.header')
@endsection


@section('content')

<body>
    <div class="form-check form-check-inline"
        style="width:100%; align-items: center; display: flex; justify-content: center;">
        <input type="checkbox" class="form-check-input" id="materialInline1" style="margin:20px;">
        <label class="form-check-label" for="materialInline1">업데이트</label>
        <input type="checkbox" class="form-check-input" id="materialInline2" style="margin:20px;">
        <label class="form-check-label" for="materialInline2">조회수</label>
        <input type="checkbox" class="form-check-input" id="materialInline3" style="margin:20px;">
        <label class="form-check-label" for="materialInline3">좋아요</label>
        <input type="checkbox" class="form-check-input" id="materialInline4" style="margin:20px;">
        <label class="form-check-label" for="materialInline4">가격</label>
    </div>

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

        @foreach($products as $row)
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- 작품 -->
                    <a href="{{url('store/detail/view')}}/{{$row['num']}}">
                        <div class="single-product-wrapper" style="display:inline-block; margin-right:10px;">
                            <!-- 작품이미지 -->
                            <div class="product-img">
                                <img src="{{$row['position_of_illustration']}}" alt="작품1"
                                    style="width:200px; height:250px;">
                                <!-- <img class="hover-img" src="{{asset('image/store/product-1.png')}}" alt="" style="width:200px; height:250px;"> -->
                                <!-- <div class="product-favourite">
                                    <a href="#" class="favme fa fa-heart"></a>
                                </div> -->
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
                </div>
            </div>
        </div>
        @endforeach
    </section>

</body>

@endsection

@section('footer')
@include('layouts.store.footer')
@endsection
