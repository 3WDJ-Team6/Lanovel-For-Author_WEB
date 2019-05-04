@extends('layouts.store.master')

@section('head')
@include('layouts.store.head')
<script src="{{asset('js/add_image.js')}}" defer></script>
<script src="{{asset('js/store/upload_price.js')}}" defer></script>
<script src="{{asset('js/store/dropzone.js')}}" defer></script>
<link rel="stylesheet" href="{{asset('css/image_add.css')}}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://rawgit.com/enyo/dropzone/master/dist/dropzone.js"></script>
<link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">
<meta name="csrf-token" content="{{ csrf_token() }}" />

@endsection

@section('header')
@include('layouts.store.header')
@endsection

@section('content')

<body>

    <div class="container" style="height:100%; margin-top:70px;">
        <div class="form-check form-check-inline" style="width:100%; display: flex; justify-content: center; margin-top:150px; margin-bottom:100px;">
            <div class="row">
                <div class="container">
                    <form action="{{url('/illustUpload')}}" class="dropzone" id="dropzone" method="post"
                        enctype="multipart/form-data" style="width:700px;">
                        @csrf
                    </form>
                    <form action="{{url('/illustStore')}}" method="post" enctype="multipart/form-data" id="store">
                        {{csrf_field()}}
                        <div class="form-group">
                            제목<input type="text" class="form-control" name="illustration_title" placeholder="70자 이내"
                                value="" />
                            <div class="form-group">
                                태그<input type="text" class="form-control" name="moreTag" placeholder="#칼 #여자"
                                    value="" /><br>

                                <div class="radioArea">
                                    종류<br>
                                    <div class="form-group">
                                        <label><input type="radio" name="division_of_illustration" id="#" value="1"
                                                style="margin:10px;">배경</label>
                                        <label><input type="radio" name="division_of_illustration" id="#" value="2"
                                                style="margin:10px;">캐릭터</label>
                                        <label><input type="radio" name="division_of_illustration" id="#" value="3"
                                                style="margin:10px;">소품</label>
                                    </div>

                                </div>

                                <div class="radioArea">
                                    <div id="price">
                                        가격<br>
                                        <label><input type="radio" name="radio_P" id="premium" value="paid"
                                                style="margin:10px;">유료</label>
                                        <label><input type="radio" name="radio_P" id="#" value="0"
                                                style="margin:10px;">무료</label>
                                    </div>

                                    <!-- 입력 사항 폼 -->
                                    <div class="form-group">
                                        <input type="text" name="price_of_illustration" class="form-control"
                                            id="paid_form" value="" />원
                                    </div>
                                </div>

                                <div class="form-group">
                                    작품 소개<input type="text" name="introduction_of_illustration" class="form-control"
                                        placeholder="제한 없음" value="" />
                                </div>

                                <button type="button" class="btnSubmit" onclick="$('#store').submit()">등록</button>
                                <button type="button" class="btnSubmit"
                                    onclick="location.href='{{url('/')}}'">취소</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        $('#paid_form').change(function () {
            $('#premium').val($(this).val());
        });

    </script>

</body>

@endsection

@section('footer')
@include('layouts.store.footer')
@endsection
