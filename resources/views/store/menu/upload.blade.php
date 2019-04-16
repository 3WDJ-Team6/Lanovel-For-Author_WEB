@extends('layouts.store.master')

@section('head')
    @include('layouts.store.head')
<script src="{{asset('js/store/upload_price.js')}}" defer></script>
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
                    <form action="{{ url('/store/upload')}}" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <input type='file' id="image" name="image" />
                        <img id="blah" src="" alt="이미지 추가" width="300" height="300" onerror="this.src='{{asset('image/no_image.png')}}'" />

                        <div class="form-group">
                            제목<input type="text" class="form-control" name="work_title" placeholder="70자 이내" value="illustration_title"
                                />
                            <div class="form- group">
                                태그<input type="text" class="form-control" name="tag" placeholder="#칼 #여자" value="tag"
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
                                        <input type="text" name="#" class="form-control" id="paid_form" value="price_of_illustration" />원
                                    </div>

                                </div>

                                <div class="form-group">
                                    작품 소개<input type="text" name="#" class="form-control" placeholder="제한 없음" value="introduce_od_illustration"
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
