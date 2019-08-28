@extends('layouts.store.master')

@section('head')
@include('layouts.store.head')
@endsection

@section('header')
@include('layouts.store.header')
@endsection

@section('content')

<body>

    {{-- <div class="form-check form-check-inline"
        style="width:100%; align-items: center; display: flex; justify-content: center;">
        <input type="checkbox" class="form-check-input" id="materialInline1" style="margin:20px;">
        <label class="form-check-label" for="materialInline1">업데이트</label>
        <input type="checkbox" class="form-check-input" id="materialInline2" style="margin:20px;">
        <label class="form-check-label" for="materialInline2">조회수</label>
        <input type="checkbox" class="form-check-input" id="materialInline3" style="margin:20px;">
        <label class="form-check-label" for="materialInline3">좋아요</label>
        <input type="checkbox" class="form-check-input" id="materialInline4" style="margin:20px;">
        <label class="form-check-label" for="materialInline4">가격</label>
    </div> --}}


    <section class="new_arrivals_area section-padding-80 clearfix">
        <div class="container">
                <div class="background" style="position: absolute; z-index:-1; left:16%; top: 7.7%;">
                        <img src="{{asset('image/store/illust_background25.png')}}" style="width:110%; margin-left: -4%; margin-top: 0%;">
                </div>
                <img src="{{asset('image/logo2.png')}}" style="    width: 710px; height:110px; margin-top: 12%; margin-left: 18%;">
            <img src="{{asset('image/store/illust_title_bg.png')}}"
                style="width:700px; height:20px; margin-top:2%; margin-left: 19%;">

            {{-- <div class="row">
                <div class="col-12">
                    <div class="section-heading text-center">
                        <h2>Products</h2>
                    </div>
                    <!-- @if(Session::has('message'))
                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                    @endif -->
                </div> --}}

            </div>
        </div>
        <!-- <div class="container"> -->

        <div class="row"
            style="    margin-left: 7%;
            margin-right: 5%;
            align-items: center;
            margin-top: 8%;
            display: flex;
            justify-content: center;">
            <!-- <div class="col-12" > -->
            @foreach($products as $row)
            <!-- 작품 -->

            <a href="{{url('/view')}}/{{$row['num']}}">
                <div style="display:inline-block; margin:3%;">
                    <!-- 작품이미지 -->
                    <div class="product-img" style="width: 200px; height: 150px;">
                        <img src="{{$row['url_of_illustration']}}" alt="작품1"
                            style="width: 200px; height: 150px; position: absolute; display:inline-block; object-fit:cover;">
                        <div class="product-favourite">
                            <a href="{{url('/addLike')}}/{{$row->num}}" class="favme fa fa-heart"></a>
                        </div>
                    </div>
                    <!-- 작품설명 -->
                    <div class="product-description">
                        <p style="font-size:12px;">{{$row->nickname}}</p>
                        <a href="{{url('/view')}}/{{$row->num}}" style="text-decoration:none;">
                            <h6>{{$row->illustration_title}}</h6>
                        </a>
                        <p class="product-price">{{$row->price_of_illustration}} p</p>

                        <!-- 마우스 -->
                        <div class="hover-content">
                            <!-- 장바구니 -->
                            <div class="add-to-cart-btn">
                                <a href="{{url('/addCart')}}/{{$row->num}}" class="btn essence-btn"
                                    style="width:100px;">Add to Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
            <!-- </div> -->
        </div>

        <!-- </div> -->
    </section>

</body>

@endsection

@section('footer')
@include('layouts.store.footer')
@endsection
