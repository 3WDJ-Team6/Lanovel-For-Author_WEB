@extends('layouts.master')

@section('head')
@include('layouts.head')
<link rel="stylesheet" href="{{asset('css/checkbox.css')}}">
@endsection

@section('header')
@include('layouts.header')
@endsection

@section('content')

<body>
    @if(Auth::user()['roles'] == 2)
    <!-- Main Content -->
    <div class="container" style="margin-top:5%;">
        <div class="form-group" style="margin-top:6%;">
            @if(Session::has('success'))
            <div class="alert alert-info">{{ Session::get('success') }}</div>
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

        {{-- 새 작품 추가  --}}
        <div class="row">
            <div class="col-lg-12 col-md-10 mx-auto">
                <div class="post-preview" style=" margin-bottom:2%;">
                    <a href="{{url('/createBook')}}">
                        <h3 class="post-title"
                            style="align-items: center; display: flex; justify-content: center; margin-bottom:5%;">
                            <img src="{{asset('image/plus.png')}}" alt="표지1"
                                style="margin-right:2%; width:60px; height:60px;">
                            <div class="add-font" style="font-size:30px; margin-bottom:0.5%;">작품추가</div>
                        </h3>
                </div>

                {{-- 작품 출력 부분  --}}

                @foreach ($posts as $post)
                <div class="form-group" style=" border-radius: 15px; box-shadow: 0px 0px 13px -5px rgba(0, 0, 0, 5);">
                    <div class="post-preview" style="width:100%; height:250px; margin-bottom:4%;">
                        <div class="form-group"
                            style="display:inline-block; margin-top:4%; margin-left:3%; width:680px;">
                            <a href="{{url('editor/main/chapter')}}/{{$post['num']}}"
                                style=" text-decoration:none; margin:0px;">
                                <img src="{{$post['bookcover_of_work']}}" alt="표지1"
                                    style="margin-top:0.3%; margin-left:2%; margin-right:5%; width:130px; height:150px; box-shadow: 0px 0px 10px -5px rgba(0, 0, 0, 1)"
                                    class="img-thumbnail" onerror="this.src='{{asset('image/no_image.png')}}'" />
                                <div class="post-title" style="width:450px; margin-top:30px; margin-bottom:30px; display:inline-flex; color:black;font-size:1.75rem;">
                                    {{ $post->work_title }}
                                <button type="button" style="margin-left:1%;display:inline-block; border: none; background-color:white; height:30px;">
                                    <img src="{{asset('image/edit.png')}}" style="cursor:pointer; display:inline-block; height:30px;"></button>
                                <button type="button" style="display:inline-block; border: none; background-color:white; height:30px;">
                                    <img src="{{asset('image/trash.png')}}" style="cursor:pointer; display:inline-block; height:30px;"></button>
                                
                                </div>
                                
                            </a>
                        </div>

                        <div class="side-group"
                            style="margin:2%; display:inline-block; float:right; align-items:right; text-align:right;">
                            <p class="post-meta"
                                style="display:inline-block; margin-bottom:0;width:350px; font-style:italic; color:#868e96; font-size:19px;">

                                카테고리 : @foreach ($tagCount as $ta)
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
                                협업 멤버 : @foreach ($user_lists as $user)
                                @if($post->num == $user->num)
                                {{ $user->nickname }}
                                @endif
                                @endforeach<br>
                                구매 : ¥ {{ $post->buy_price }}<br>
                                대여 : {{ $post->rental_price }}
                                @if($post->rental_price == null)
                                없음
                                @endif
                                <br>
                                최근 수정 시간 : @foreach ($modify_time as $time)
                                @if($post->num == $time->num_of_work)
                                {{ $time->updated_at->diffForHumans() }}
                                @endif
                                @endforeach<br>
                            </p>
                            <div>

                            </div>
                        </div>
                    </div>
                </div>

                @endforeach

            </div>

        </div>
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
