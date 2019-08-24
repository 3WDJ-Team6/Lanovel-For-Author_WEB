@extends('layouts.master')

@section('head')
@include('layouts.head')
<link rel="stylesheet" href="{{asset('css/checkbox.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/normalize.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('css/demo.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('css/book.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('css/index.css')}}" />
<script src="{{asset('js/modernizr.custom.js')}}"></script>
<style>
    body {}

</style>
@endsection

@section('header')
@include('layouts.header')
@endsection

@section('content')

<body>
    @if(Auth::user()['roles'] == 2)
    <!-- Main Content -->
    <!-- <div class="image" style="width:100px;">
    </div> -->
    <div class="container_box">
        <div class="background" style="position: absolute; z-index:-1; left:16%; top: 7.7%;">
            <img src="{{asset('image/main_box.png')}}" style="width:110%;height:2700px;">
        </div>
        <div class="form-group " style="display:block;">

            {{-- 정렬 필터링  --}}
            <input type="hidden" name="_token" value="{{ Session::token() }}">

            <script>
                $.ajax({
                    type: 'POST',
                    url: '/',
                    data: {
                        status_of_work: $('input:checkbox:checked').val()
                    },
                    success: function (data) {
                        alert(data);
                    }
                });

            </script>
            <img src="{{asset('image/logo2.png')}}" style="width:600px; height:90px; margin-top: 8%;    margin-left: 3%;">
            <img src="{{asset('image/writing_room_bg.png')}}"
                style="width:700px; height:20px; margin-top:3%; margin-left: 3%; ">
            @if(Session::has('success'))
            <div class="alert alert-info" style="border: none; color: black; background: none; margin:10%; font-size: 30px">
                {{ Session::get('success') }}<br>{{Session::get('success2')}}
            </div>
            @endif
            <!-- Material inline 1 -->
            <form method="POST" id="filter" style="display:block; text-align: left; margin:10%; margin-bottom:0;">
                {{ csrf_field() }}
                <label class='with-square-checkbox' style="margin:2%;">
                    <input type='checkbox'>
                    <span>회차</span>
                </label>
                <label class='with-square-checkbox' style="margin:2%;">
                    <input type='checkbox' name="type_of_work[]" value="3">
                    <span>단행본</span>
                </label>
                <label class='with-square-checkbox' style="margin:2%;">
                    <input type='checkbox' name="type_of_work[]" value="3">
                    <span>단편</span>
                </label>
                <label class='with-square-checkbox' style="margin:2%;">
                    <input type='checkbox' name="type_of_work[]" value="3">
                    <span>연재중</span>
                </label>
                <label class='with-square-checkbox' style="margin:2%;">
                    <input type='checkbox' name="type_of_work[]" value="3">
                    <span>완결작</span>
                </label>
            </form>
            <hr style="width:90%; margin-left:7%;">
        </div>

        <div class="search-container">
            <form action="/action_page.php">
                <input type="text" placeholder="Search.." name="search" style="width:86%; margin-left:7%;">
                <button type="submit" style="margin-left:1%;"><i class="fa fa-search"></i></button>
            </form>
        </div>
        <!-- 새 작품 추가 -->
        <!-- <div class="row">
            <div class="col-lg-12 col-md-10 mx-auto">
                <div class="post-preview">
                    <a href="{{url('/createBook')}}">

                        <h3 class="post-title" style="align-items: center; display: flex; justify-content: center;">
                            <img src="{{asset('image/add.png')}}" alt="표지1"
                                style="margin-right:2%; width:40px; height:auto;">
                            <div class="add-font" style="font-size:30px; color:#ea4c4c;">作品追加</div>

                        </h3>
                </div>
            </div>

        </div> -->

        <!-- 작품 출력 부분 -->

        <div class="component" style="display:block; top:32%; left:24%; ">

            <ul class="align">
                @foreach ($posts as $post)
                <li style="margin-top: 7%;">
                    <div class="background_book" style="width:110%; height:300px; margin-left:-3.5%; marin-top:10%">
                        <img src="{{asset('image/book_bg4.png')}}" style="width:100%; height:300px; ">
                        <div class="information_book" style="width:1000px; margin-top: -21%; margin-left: 14%;">
                            <figure class='book'>
                                <a href="{{url('editor/main/chapter')}}/{{$post['num']}}">
                                    <!-- Front -->

                                    <ul class='hardcover_front'>
                                        <li>
                                            <!-- <div class="coverDesign yellow" style="z-index:1 ;width:200px; height:250px;"> -->
                                                <img src="{{$post['bookcover_of_work']}}" alt="표지1" style="width:100%; height:100%;">
                                            <!-- </div> -->
                                        </li>
                                        <li></li>
                                    </ul>

                                    <!-- Pages -->

                                    <ul class='page'>
                                        <li></li>
                                        <li></li>
                                        <li></li>
                                        <li></li>
                                        <li></li>
                                    </ul>

                                    <!-- Back -->

                                    <ul class='hardcover_back'>
                                        <li></li>
                                        <li></li>
                                    </ul>
                                    <ul class='book_spine'>
                                        <li></li>
                                        <li></li>
                                    </ul>
                                    <figcaption>
                                        <h1 style="width:500px;">{{ $post->work_title }}</h1>
                                        <span style="color:#ea4c4c;">By @foreach ($user_lists as $user)
                                            @if($post->num == $user->num)
                                            {{ $user->nickname }}
                                            @endif
                                            @endforeach</span>
                                        <p>カテゴリー : @foreach ($tagCount as $ta)
                                            @if($post->num == $ta->num)
                                            {{ $ta->tag }}
                                            @endif
                                            @endforeach <br>
                                            連載の種類 : @switch( $post->type_of_work )
                                            @case(1)
                                            단편
                                            @break
                                            @case(2)
                                            単行本
                                            @break
                                            @case(3)
                                            各回
                                            @endswitch
                                            <br>
                                            連載の周期 :
                                            @foreach ($periodCount as $pe)
                                            @if($post->num == $pe->num)
                                            @switch( $pe->cycle_of_publish )
                                            @case('mon')
                                            월요일
                                            @break
                                            @case('tue')
                                            화요일
                                            @break
                                            @case('wed')
                                            水曜日
                                            @break
                                            @case('thr')
                                            목요일
                                            @break
                                            @case('fri')
                                            금요일
                                            @break
                                            @case('sat')
                                            土曜日
                                            @break
                                            @case('sun')
                                            일요일
                                            @break
                                            @default
                                            毎月 {{ $pe->cycle_of_publish }}日
                                            @break
                                            @endswitch
                                            @endif
                                            @endforeach<br>
                                            購買 : {{ ($post->buy_price)/10 }}￥<br>
                                            貸与 : {{ ($post->rental_price)/10 }}￥
                                            @if($post->rental_price == null)
                                            없음
                                            @endif
                                            <br>
                                            {{-- 修正時間 : @foreach ($modify_time as $time)
                                            @if($post->num == $time->num_of_work)
                                            {{ $time->updated_at->diffForHumans() }}
                                            @endif
                                            @endforeach --}}
                                        </p>
                                    </figcaption>
                                </a>
                            </figure>
                        </div>
                    </div>
                </li>

                {{-- <li>
                    <figure class='book'>
                        <a href="{{url('editor/main/chapter')}}/{{$post['num']}}">
                            <!-- Front -->

                            <ul class='hardcover_front'>
                                <li>
                                    <div class="coverDesign yellow">
                                        <img src="{{$post['bookcover_of_work']}}" alt="표지1"
                                            style="width:160px; height:auto;">
                                    </div>
                                </li>
                                <li></li>
                            </ul>

                            <!-- Pages -->

                            <ul class='page'>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                            </ul>

                            <!-- Back -->

                            <ul class='hardcover_back'>
                                <li></li>
                                <li></li>
                            </ul>
                            <ul class='book_spine'>
                                <li></li>
                                <li></li>
                            </ul>
                            <figcaption>
                                <h2 style="width:500px;">{{ $post->work_title }}</h2>
                                <span style="color:#ea4c4c;">By @foreach ($user_lists as $user)
                                    @if($post->num == $user->num)
                                    {{ $user->nickname }}
                                    @endif
                                    @endforeach</span>
                                <p>카테고리 : @foreach ($tagCount as $ta)
                                    @if($post->num == $ta->num)
                                    {{ $ta->tag }}
                                    @endif
                                    @endforeach <br>
                                    연재 종류 : @switch( $post->type_of_work )
                                    @case(1)
                                    단편
                                    @break
                                    @case(2)
                                    단행본
                                    @break
                                    @case(3)
                                    회차
                                    @endswitch
                                    <br>
                                    연재 주기 :
                                    @foreach ($periodCount as $pe)
                                    @if($post->num == $pe->num)
                                    @switch( $pe->cycle_of_publish )
                                    @case('mon')
                                    월요일
                                    @break
                                    @case('tue')
                                    화요일
                                    @break
                                    @case('wed')
                                    수요일
                                    @break
                                    @case('thr')
                                    목요일
                                    @break
                                    @case('fri')
                                    금요일
                                    @break
                                    @case('sat')
                                    토요일
                                    @break
                                    @case('sun')
                                    일요일
                                    @break
                                    @default
                                    매달 {{ $pe->cycle_of_publish }}일
                                    @break
                                    @endswitch
                                    @endif
                                    @endforeach<br>
                                    구매 : {{ $post->buy_price }}원<br>
                                    대여 : {{ $post->rental_price }}원
                                    @if($post->rental_price == null)
                                    없음
                                    @endif
                                    <br>
                                    최근 수정 시간 : @foreach ($modify_time as $time)
                                    @if($post->num == $time->num_of_work)
                                    {{ $time->updated_at->diffForHumans() }}
                                    @endif
                                    @endforeach
                                </p>
                            </figcaption>
                        </a>
                    </figure>
                </li> --}}


                    @endforeach

            </ul>
        </div>
    </div> <!-- container -->

    </div>
    @else
    <script type="text/javascript">
        alert('52 그 앞은 작.가.영.역.이.다');
        // window.history.back();
        window.location = "{{ url('/store') }}";

    </script>
    @endif
</body>


@endsection

@section('footer')
@include('layouts.footer')
@endsection
