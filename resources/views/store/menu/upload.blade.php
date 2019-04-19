@extends('layouts.store.master')

@section('head')
    @include('layouts.store.head')
<script src="{{asset('js/store/upload_price.js')}}" defer></script>
<script src="{{asset('js/store/upload_image.js')}}" defer></script>
<script src="{{asset('js/book_add_cycle_month.js')}}" defer></script>
<link rel="stylesheet" href="{{asset('css/book_add.css')}}">
<script src="https://rawgit.com/enyo/dropzone/master/dist/dropzone.js"></script>
<link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">

@endsection

@section('header')
    @include('layouts.store.header')
@endsection


@section('content')

<body>

    <div class="container" style="height:1100px; margin-top:70px;">
        <div class="form-check form-check-inline" style="width:100%; display: flex; justify-content: center;">
            <div class="row">
                <div class="container">
                <div id="body-overlay">
                    <div><img src="{{asset('image/loading.gif')}}" width="64px" height="64px" /></div>
                </div>
                <div class="bgColor">
                    <form id="uploadForm" action="upload.php" method="post">
                        <div id="targetOuter">
                            <div id="targetLayer"></div>
                            <img src="" class="icon-choose-image" onerror="this.src='{{asset('image/photo.png' )}}'" />
                            <div class="icon-choose-image">
                                <input name="userImage" id="userImage" type="file" class="inputFile"
                                    onChange="showPreview(this);" />
                            </div>
                        </div>
                        <div>
                            <span>image name</span>
                        </div>
                    </form>
                </div>

                        <div class="form-group">
                            제목<input type="text" class="form-control" name="illustration_title" placeholder="70자 이내" value=""
                                />
                            <div class="form- group">
                                태그<input type="text" class="form-control" name="tag" placeholder="#칼 #여자" value=""
                                    /><br>

                                <div class="radioArea">
                                    종류<br>
                                    <div class="form-group">
                                        <label><input type="radio" name="#" id="#" value="background"
                                                style="margin:10px;">배경</label>
                                        <label><input type="radio" name="#" id="#" value="character"
                                                style="margin:10px;">캐릭터</label>
                                        <label><input type="radio" name="#" id="#" value="prop"
                                                style="margin:10px;">소품</label>
                                    </div>

                                </div>

                                <div class="radioArea">
                                    <div id="price">
                                        가격<br>
                                        <label><input type="radio" name="radio_P" id="premium" value="paid"
                                                style="margin:10px;">유료</label>
                                        <label><input type="radio" name="radio_P" id="#" value="free"
                                                style="margin:10px;">무료</label>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="price_of_illustration" class="form-control" id="paid_form" value="" />원
                                    </div>

                                </div>

                                <div class="form-group">
                                    작품 소개<input type="introduce_of_illustration" name="#" class="form-control" placeholder="제한 없음" value=""
                                         />
                                </div>

                                <button type="submit" class="btnSubmit">등록</button>
                                <button type="button" class="btnSubmit"
                                    onclick="location.href='{{url('/')}}'">취소</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

@endsection

@section('footer')
@include('layouts.store.footer')
@endsection