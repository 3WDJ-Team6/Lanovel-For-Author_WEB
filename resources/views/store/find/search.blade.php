@extends('layouts.store.master')

@section('head')
@include('layouts.store.head')
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="{{asset('css/store/find_search.css')}}">
<script src="{{asset('js/store/search_make.js')}}"></script>
<script src="{{asset('js/store/search_price.js')}}"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- <script src="{{asset('css/store/find_tag.css')}}"></script> -->

<style>
    #find_tag #find_price #find_detail {
        display: none;
    }
</style>
@endsection

@section('header')
@include('layouts.store.header')
@endsection


@section('content')

<body>

    <section class="new_arrivals_area section-padding-80 clearfix">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="#" href="#">
                    <h3>Detail Navbar</h3>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                    aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-item nav-link" id="tag" href="#">태그</a>
                        <a class="nav-item nav-link" id="price" href="#">가격</a>
                        <a class="nav-item nav-link" id="detail" href="#">상세</a>
                    </div>
                </div>
            </nav>
            <!-- 상세검색 navbar -->
            <div class="find" id="find">
                <div class="row" id="find_tag">

                    <!-- tag -->
                    <div class="col-md-3">
                        <label class="checkbox-inline">
                            <input type="checkbox" value="">이세계
                        </label><br>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="">학원물
                        </label><br>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="" >몬스터
                        </label><br>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="" >판타지
                        </label><br>
                    </div>

                    <div class="col-md-3">

                        <label class="checkbox-inline">
                            <input type="checkbox" value="">공포
                        </label><br>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="">SF
                        </label><br>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="">북유럽 신화
                        </label><br>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="" >메카닉
                        </label><br>

                    </div>

                    <div class="col-md-3">

                        <label class="checkbox-inline">
                            <input type="checkbox" value="">양손검
                        </label><br>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="">바다
                        </label><br>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="">그리스 신화
                        </label><br>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="">크툴루 신화
                        </label><br>
                    </div>


                    <div class="col-md-3">

                        <label class="checkbox-inline">
                            <input type="checkbox" value="">마왕
                        </label><br>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="">금발
                        </label><br>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="">도시
                        </label><br>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="">트윈테일
                        </label><br>

                    </div>
                </div>

                <div class="row" id="find_price">
                    <!-- price -->
                    <p>
                        <label for="amount">Price range:</label>
                        <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
                    </p>

                    <div id="slider-range"></div>
                </div>

                <div id="find_detail">

                    <div class="form- group">
                        태그<input type="text" class="form-control" name="tag" placeholder="#칼 #여자" value="" /><br>
                        제목<input type="text" class="form-control" name="work_title" placeholder="" value="" />
                        작가명<input type="text" class="form-control" name="work_title" placeholder="" value="" />
                        가격대<input type="text" class="form-control" name="work_title" value="" />
                        <input type="text" class="form-control" name="work_title" value="" />

                        <div class="radioArea">
                            무료<br>
                            <div class="form-group">
                                <label><input type="radio" name="free" id="#" value="#" style="margin:10px;">포함</label>
                                <label><input type="radio" name="free" id="#" value="#" style="margin:10px;">제외</label>

                            </div>

                        </div>
                    </div>
                </div>

                <!-- find -->
            </div>
            <div id="row" class="search">
            <button type="button submit" class="btn btn-outline-dark">검색</button>
            </div>
        </div>
    </section>


</body>

@endsection

@section('footer')
@include('layouts.store.footer')
@endsection
