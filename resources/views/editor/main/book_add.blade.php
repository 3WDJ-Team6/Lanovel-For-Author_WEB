@extends('layouts.master')

@section('head')
@include('layouts.head')
<script src="{{asset('js/add_image.js')}}" defer></script>
<script src="{{asset('js/book_add_type.js')}}" defer></script>
<script src="{{asset('js/book_add_cycle.js')}}" defer></script>
<script src="{{asset('js/book_add_cycle_month.js')}}" defer></script>
<script src="{{asset('js/book_add_price.js')}}" defer></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
<link rel="stylesheet" href="{{asset('css/image_add.css')}}">
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
<div class="container" style="height:100%; background-color:#fffffa; margin-top:70px;">
    <div class="form-check form-check-inline" style="width:100%; display: flex; justify-content: center;">
        <div class="row" style="margin:100px;">
            <form action="{{url('/addBook')}}" method="post" enctype="multipart/form-data" class="form-horizontal">
                {{csrf_field()}}

                <!-- <form runat="server"> -->
                    <input type="file" id="imgInp" name="image" /><br>
                    <img id="blah" src="{{asset('image/photo.png')}}" style="display:inline-block; width:100px; margin-top:3%;" alt="your image" />
                <!-- </form> -->
                <!-- <div class="bgColor"> -->
                    <!-- <form id="uploadForm" action="{{url('/addBook')}}" method="post"> -->
                    <!-- <div id="targetOuter">
                        <div id="targetLayer"></div>
                        <img src="" class="icon-choose-image" onerror="this.src='{{asset('image/photo.png' )}}'" />
                        <div class="icon-choose-image">
                            <input name="image" id="userImage" type="file" class="inputFile" onChange="showPreview(this);" />
                        </div>
                    </div>
                    <div>
                        <span>image name</span>
                    </div> -->
                    <!-- </form> -->
                <!-- </div> -->

                <div class="form-group">
                    제목<input type="text" class="form-control" name="work_title" placeholder="70자 이내" value="" style="width:400px;" />
                    <div class="form- group">
                        태그<input type="text" class="form-control" name="tag" placeholder="#로맨스 #판타지" value=""
                            style="width:400px;" /><br>
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
                                    <label><input type="radio" name="radio_C" id="changeRadio_C" value="2-1" style="margin:10px;">주간</label>
                                    <label><input type="radio" name="radio_C" id="changeRadio_C" value="2-2" style="margin:10px;">월간</label>
                                </div>
                            </div>

                            {{-- 단행본, 회차 선택 시 --}}
                            <div id="changeTextArea_C">

                                {{-- 주간 선택 시 --}}
                                <div id="change_w">
                                    <label>월</label><input type="checkbox" name="cycle_of_work[]" value="mon" style="margin-right:10px;">
                                    <label>화</label><input type="checkbox" name="cycle_of_work[]" value="tue" style="margin-right:10px;">
                                    <label>수</label><input type="checkbox" name="cycle_of_work[]" value="wed" style="margin-right:10px;">
                                    <label>목</label><input type="checkbox" name="cycle_of_work[]" value="thu" style="margin-right:10px;">
                                    <label>금</label><input type="checkbox" name="cycle_of_work[]" value="fri" style="margin-right:10px;">
                                    <label>토</label><input type="checkbox" name="cycle_of_work[]" value="sat" style="margin-right:10px;">
                                    <label>일</label><input type="checkbox" name="cycle_of_work[]" value="sun" style="margin-right:10px;">
                                </div>
                                {{-- 월간 선택 시 --}}
                                <div id="change_c">
                                    <p>Date: <input type="text" id="datepicker" name="cycle_of_work[]" size="30" select id="anim"></p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            가격<input type="text" name="buy_price" class="form-control" style="width:400px;" id="comma" onkeyup="commas(this)" />원
                        </div>
                        <div class="form-group" id="rent">
                            대여 가격<input type="text" name="rental_price" class="form-control" id="rent"
                                onkeyup="commas(this)" style="width:400px;" numberOnly />원
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
@endsection

@section('footer')
@include('layouts.footer')
@endsection
