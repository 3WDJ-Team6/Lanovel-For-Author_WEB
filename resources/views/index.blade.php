@extends('layouts.master')

@section('head')
@include('layouts.head')
@endsection

@section('header')
@include('layouts.header')
@endsection

@section('content')

<body>

    <!-- Main Content -->
    <div class="container">
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
                    success: function(data) {
                        alert(data);
                    }
                });
            </script>

            <!-- Material inline 1 -->
            <form method="POST" id="filter">
                {{ csrf_field() }}
                <div class="form-check form-check-inline" style="width:100%; align-items: center; display: flex; justify-content: center;">
                    <input type="checkbox" class="form-check-input" id="materialInline1" style="margin:20px;" name="type_of_work[]" value="3">
                    <label class="form-check-label" for="materialInline1">회차</label>
                    <input type="checkbox" class="form-check-input" id="materialInline2" style="margin:20px;" name="type_of_work[]" value="2">
                    <label class="form-check-label" for="materialInline2">단행본</label>
                    <input type="checkbox" class="form-check-input" id="materialInline5" style="margin:20px;" name="type_of_work[]" value="1">
                    <label class="form-check-label" for="materialInline5">단편</label>
                    <input type="checkbox" class="form-check-input" id="materialInline3" style="margin:20px;" name="status_of_work[]" value="1">
                    <label class="form-check-label" for="materialInline3">연재중</label>
                    <input type="checkbox" class="form-check-input" id="materialInline4" style="margin:20px;" name="status_of_work[]" value="2">
                    <label class="form-check-label" for="materialInline4">완결작</label>
                </div>
            </form>
        </div>

        {{-- 새 작품 추가  --}}
        <div class="row">
            <div class="col-lg-12 col-md-10 mx-auto">
                <div class="post-preview" style="">
                    <a href="{{url('/createBook')}}">
                        <h3 class="post-title" style="margin-top:30px; margin-bottom:30px;">
                            <img src="{{asset('image/plus.png')}}" alt="표지1" style="width:130px; height:150px;" class="img-thumbnail">
                            작품추가
                        </h3>
                </div>
                <hr>
                {{-- 작품 출력 부분  --}}

                @foreach ($posts as $post)
                <div class="form-group" style="background-color:#45b4e61a; border-radius: 15px;">
                    <div class="post-preview" style="width:100%; height:230px; ">
                        <div class="form-group" style="display:inline-block; margin:2%;">
                            <a href="{{url('editor/main/chapter')}}/{{$post['num']}}"
                                style=" text-decoration:none; margin:0px;">
                                <img src="{{$post['bookcover_of_work']}}" alt="표지1" style="width:130px; height:150px;"
                                    class="img-thumbnail" onerror="this.src='{{asset('image/no_image.png')}}'" />
                                <div class="post-title h2"
                                    style=" margin-top:30px; margin-bottom:30px; display:inline-flex; color:black;">

                                    {{ $post->work_title }}
                                </div>
                            </a>
                        </div>
                        <div class="side-group"
                            style="display:inline-block; margin:2%; margin-right:3%; float:right; align-items:right; text-align:right;">
                            <p class="post-meta" style="font-style:italic;color:#868e96;font-size:18px;">
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
                        </div>
                    </div>
                </div>
                <hr>
                @endforeach

            </div>

        </div>
    </div>

    <script>

    </script>

</body>


@endsection

@section('footer')
@include('layouts.footer')
@endsection
