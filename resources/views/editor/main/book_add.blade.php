@extends('layouts.master')

@section('head')
    @include('layouts.head')
<script src="{{asset('js/editor/book_add_image.js')}}" defer></script>
<script src="{{asset('js/editor/book_add_type.js')}}" defer></script>
<script src="{{asset('js/editor/book_add_cycle.js')}}" defer></script>
<script src="{{asset('js/editor/book_add_cycle_month.js')}}" defer></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!-- <link rel="stylesheet" href="/resources/demos/style.css"> -->
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<style>
    #change2 #change3 #change_w #change_c {
        display: none;
    }
</style>
@endsection

@section('header')
    @include('layouts.header')
@endsection


@section('content')
<div class="container" style="height:1100px;; background-color:#45b4e61a; margin-top:70px;">
    <div class="form-check form-check-inline" style="width:100%; display: flex; justify-content: center;">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto" style="margin-top:50px; margin-bottom:50px;">
                <div class="container">
                    <form action="{{action('WorkOut\IndexController@store')}}" method="post">
                        <input type='file' id="upload_file" name="bookcover_of_work" />
                        <img id="blah" src="{{asset('image/add.png')}}" alt="표지 추가" width="100" height="100" />
                        <div class="form-group">
                            제목<input type="text" class="form-control" name="work_title" placeholder="70자 이내" value="" style="width:400px;" />
                            <div class="form- group">
                                태그<input type="text" class="form-control" name="tag" placeholder="#로맨스 #판타지" value="" style="width:400px;" /><br>

                                <div class="radioArea">
                                    종류<br>
                                    <div class="form-group">
                                        <!-- value 값 데려올 때 type_of_work 대신 radio_T를 써야한다 -->
                                        <label><input type="radio" name="radio_T" id="changeRadio_T" value="1" style="margin:10px;">단편</label>
                                        <label><input type="radio" name="radio_T" id="changeRadio_T" value="2" style="margin:10px;">단행본</label>
                                        <label><input type="radio" name="radio_T" id="changeRadio_T" value="3" style="margin:10px;">회차</label>
                                    </div>


                                    {{-- 선택 사항 --}}
                                    <div id="changeTextArea_T">
                                        {{-- 단편 선택 시 --}}
                                        <div id="change1">

                                        </div>
                                        {{-- 단행본, 회차 선택 시 --}}
                                        <div id="change2">
                                            연재방식<br>
                                            <label><input type="radio" name="radio_C" id="changeRadio_C" value="2-1" style="margin:10px;">주간</label>
                                            <label><input type="radio" name="radio_C" id="changeRadio_C" value="2-2" style="margin:10px;">월간</label><br>
                                        </div>
                                        {{-- 회차 선택 시 --}}
                                        <div id="change3">
                                            연재방식<br>
                                            <label><input type="radio" name="radio_C" id="changeRadio_C" value="3-1" style="margin:10px;">주간</label>
                                            <label><input type="radio" name="radio_C" id="changeRadio_C" value="3-2" style="margin:10px;">월간</label>
                                        </div>
                                    </div>

                                    {{-- 단행본, 회차 선택 시 --}}
                                    <div id="changeTextArea_C">

                                        {{-- 주간 선택 시 --}}
                                        <div id="change_w">
                                            <label>월</label><input type="checkbox" name="cycle_of_work" value="월" style="margin-right:10px;">
                                            <label>화</label><input type="checkbox" name="cycle_of_work" value="화" style="margin-right:10px;">
                                            <label>수</label><input type="checkbox" name="cycle_of_work" value="수" style="margin-right:10px;">
                                            <label>목</label><input type="checkbox" name="cycle_of_work" value="목" style="margin-right:10px;">
                                            <label>금</label><input type="checkbox" name="cycle_of_work" value="금" style="margin-right:10px;">
                                            <label>토</label><input type="checkbox" name="cycle_of_work" value="토" style="margin-right:10px;">
                                            <label>일</label><input type="checkbox" name="cycle_of_work" value="일" style="margin-right:10px;">
                                        </div>
                                        {{-- 월간 선택 시 --}}
                                        <div id="change_c">
                                            <p>Date: <input type="text" id="datepicker" size="30" select id="anim"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    가격<input type="text" name="buy_price" class="form-control" placeholder=" " value="" style="width:400px;" />원
                                </div>
                                <div class="form-group" id="rent">
                                    대여 가격<input type="text" name="rental_price" class="form-control" id="rent" placeholder=" " value="" style="width:400px;" />원
                                </div>
                                <div class="form-group">
                                    작품 소개<input type="text" name="introduction_of_work" class="form-control" placeholder="제한 없음" value="" style="width:400px; height:100px;" />
                                </div>
                                <button type="submit" class="btnSubmit">등록</button>
                                <button type="button" class="btnSubmit" onclick="location.href='{{url('/')}}'">취소</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 

@section('footer')
    @include('layouts.footer')
@endsection

