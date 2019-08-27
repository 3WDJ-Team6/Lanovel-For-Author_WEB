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
    ::-webkit-scrollbar {
        display: none;
    }
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
            <img src="{{asset('image/main_box.png')}}" style="width:110%;">
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
            <img src="{{asset('image/logo2.png')}}"
                style="width:600px; height:90px; margin-top: 8%;    margin-left: 3%;">
            <img src="{{asset('image/writing_room_bg.png')}}"
                style="width:700px; height:20px; margin-top:3%; margin-left: 3%; ">
            @if(Session::has('success'))
            <div class="alert alert-info"
                style=" border: none;
                        color: black;
                        background: none;
                        margin: 6%;
                        margin-left: 14%;
                        font-size: 45px;">
                {{ Session::get('success') }}<br>{{Session::get('success2')}}
            </div>
            @endif
            <!-- Material inline 1 -->
            <form method="POST" id="filter" style="display:block; text-align: left; margin:10%; margin-bottom:0;">
                {{ csrf_field() }}
                <label class='with-square-checkbox' style="margin:2%;">
                    <input type='checkbox'>
                    <span>話配信</span>
                </label>
                <label class='with-square-checkbox' style="margin:2%;">
                    <input type='checkbox' name="type_of_work[]" value="3">
                    <span>単行本</span>
                </label>
                <label class='with-square-checkbox' style="margin:2%;">
                    <input type='checkbox' name="type_of_work[]" value="3">
                    <span>短編</span>
                </label>
                <label class='with-square-checkbox' style="margin:2%;">
                    <input type='checkbox' name="type_of_work[]" value="3">
                    <span>連載中</span>
                </label>
                <label class='with-square-checkbox' style="margin:2%;">
                    <input type='checkbox' name="type_of_work[]" value="3">
                    <span>完結済み</span>
                </label>
            </form>
            <hr style="width:90%; margin-left:7%;">
        </div>

        <div class="search-container">
            <form action="/action_page.php">
                <input type="text" placeholder="Search.." name="search" style="width:86%; margin-left:7%;margin-bottom: 5%;">
                <button type="submit" style="margin-left:-4%;"><i class="fa fa-search"></i></button>
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
            <script>
                var a = 0;

            </script>
            <ul class="align">
                @foreach ($posts as $post)
                <li style="margin-top: 7%;">
                    <div class="background_book" style="width:110%; height:340px; margin-left:-4.1%;">
                        <script>
                            if(a>4){
                                a = 0;
                            }
                            a++;
                            var img_book = "";
                            img_book = "<img src='/image/book_bg" + a + ".png' style='width:100%;height:300px;'>"
                            console.log(a);
                            document.write(img_book);
                        </script>
                        <div class="information_book" style="width:1000px; margin-top: -21%; margin-left: 14%;">
                            <figure class='book'>
                                <a href="{{url('editor/main/chapter')}}/{{$post['num']}}">
                                    <!-- Front -->

                                    <ul class='hardcover_front' style="left: -14%;top: -30%;width: 107%;height: 107%;">
                                        <li style="width: 100%;height: 100%;">
                                            <img src="{{$post['bookcover_of_work']}}" alt="표지1" style="width: 140%;height: 140%;left: 1%;">
                                        </li>
                                        <li style="width: 115%;height: 130%;"></li>
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
                                        <li style="height: 0px;width: 257px;"></li>
                                        <li></li>
                                    </ul>
                                    <figcaption>
                                        <h1 style="width: 500px;position: fixed;top: -40%;">{{ $post->work_title }}</h1>
                                        <span style="color: #ea4c4c;margin-bottom: 5%;position: fixed;top: -20%;width: 350px;left: 130%;">By @foreach ($user_lists as $user)
                                            @if($post->num == $user->num)
                                            {{ $user->nickname }}
                                            @endif
                                            @endforeach</span>
                                        <p style="width: 330px;padding-top: 20%;">カテゴリー : @foreach ($tagCount as $ta)
                                            @if($post->num == $ta->num)
                                            {{ $ta->tag }}
                                            @endif
                                            @endforeach <br>
                                            連載方式 : @switch( $post->type_of_work )
                                            @case(1)
                                            短編
                                            @break
                                            @case(2)
                                            単行本
                                            @break
                                            @case(3)
                                            話配信
                                            @endswitch
                                            <br>
                                            連載周期 :
                                            @foreach ($periodCount as $pe)
                                            @if($post->num == $pe->num)
                                            @switch( $pe->cycle_of_publish )
                                            @case('mon')
                                            月曜日
                                            @break
                                            @case('tue')
                                            火曜日
                                            @break
                                            @case('wed')
                                            水曜日
                                            @break
                                            @case('thr')
                                            木曜日
                                            @break
                                            @case('fri')
                                            金曜日
                                            @break
                                            @case('sat')
                                            土曜日
                                            @break
                                            @case('sun')
                                            日曜日
                                            @break
                                            @default
                                            毎月 {{ $pe->cycle_of_publish }}日
                                            @break
                                            @endswitch
                                            @endif
                                            @endforeach<br>
                                            購入 : {{ ($post->buy_price)/10 }}円<br>
                                            レンタル : {{ ($post->rental_price)/10 }}円
                                            @if($post->rental_price == null)
                                            なし
                                            @endif
                                            {{-- <br>
                                            アップデート : @foreach ($modify_time as $time)
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
                @endforeach
            </ul>
        </div>
    </div>

    </div>
    <a href="{{url('/store')}}"><img class="illustore" src="/image/illust_btn_sm.png"></a>
    @else
    <script type="text/javascript">
        alert('おい、その前は作．家．の．縄．張．り．だ');
        // window.history.back();
        window.location = "{{ url('/store') }}";
    </script>
    @endif
</body>
@endsection
