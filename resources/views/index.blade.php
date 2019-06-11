@extends('layouts.master')

@section('head')
@include('layouts.head')
<link rel="stylesheet" href="{{asset('css/checkbox.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/normalize.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('css/demo.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('css/book.css')}}" />
<script src="{{asset('js/modernizr.custom.js')}}"></script>
<style>
body {
    background-color:#fffffa;
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
    <div class="container col-10" style="margin-top:5%;">
        <div class="form-group " style="margin-top:6%;">
            @if(Session::has('success')) 
            <div class="alert alert-info" style="max-width: 1140px; margin-right: auto; margin-left: auto;">
            {{ Session::get('success') }}
            </div>
            @endif
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


            <!-- Material inline 1 -->
            <form method="POST" id="filter"
                style="display:block; align-items: center; display: flex; justify-content: center;">
                {{ csrf_field() }}
                <label class="container-checkbox">회차
                    <input type="checkbox" name="type_of_work[]" value="3">
                    <span class="checkmark"></span>
                </label>
                <label class="container-checkbox">단행본
                    <input type="checkbox" name="type_of_work[]" value="3">
                    <span class="checkmark"></span>
                </label>
                <label class="container-checkbox">단편
                    <input type="checkbox" name="type_of_work[]" value="3">
                    <span class="checkmark"></span>
                </label>
                <label class="container-checkbox">연재중
                    <input type="checkbox" name="type_of_work[]" value="3">
                    <span class="checkmark"></span>
                </label>
                <label class="container-checkbox">완결작
                    <input type="checkbox" name="type_of_work[]" value="3">
                    <span class="checkmark"></span>
                </label>
            </form>
        </div>
        <!-- 새 작품 추가 -->
        <div class="row">
            <div class="col-lg-12 col-md-10 mx-auto">
                <div class="post-preview">
                    <a href="{{url('/createBook')}}">
                        <h3 class="post-title" style="align-items: center; display: flex; justify-content: center;">
                            <img src="{{asset('image/add.png')}}" alt="표지1"
                                style="margin-right:2%; width:40px; height:auto;">
                            <!-- <div class="add-font" style="font-size:30px; color:#ea4c4c;">作品追加</div> -->
                        </h3>
                </div>
            </div>

        </div>

        <!-- 작품 출력 부분 -->
        <div class="component col-12">

            <ul class="align">
                @foreach ($posts as $post)

                <li>
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
                                <h1 style="width:500px;">{{ $post->work_title }}</h1>
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

                </li>
                @endforeach

            </ul>
        </div>
    </div><!-- /container -->



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
