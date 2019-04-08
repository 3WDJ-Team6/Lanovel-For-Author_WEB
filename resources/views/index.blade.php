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
<div class="container" style="background-color:#45b4e61a; margin-top:70px;">

    @if(\Auth::check())
    {{-- <p>{{ Auth::user() }}</p> --}}
    <div>
        <a href="{{url('assets/upload')}}">asset upload</a>
    </div>
    @else 비 로그인 상태 @endif @if(Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif
    <div>
        {{Auth::user()['nickname']}}
    </div>
    {{-- 정렬 필터링  --}}
    <input type="hidden" name="_token" value="{{ Session::token() }}">

    <!-- Material inline 1 -->
    <div class="form-check form-check-inline"
        style="width:100%; align-items: center; display: flex; justify-content: center;">
        <input type="checkbox" class="form-check-input" id="materialInline1" style="margin:20px;">
        <label class="form-check-label" for="materialInline1">회차</label>
        <input type="checkbox" class="form-check-input" id="materialInline2" style="margin:20px;">
        <label class="form-check-label" for="materialInline2">단행본</label>
        <input type="checkbox" class="form-check-input" id="materialInline3" style="margin:20px;">
        <label class="form-check-label" for="materialInline3">연재중</label>
        <input type="checkbox" class="form-check-input" id="materialInline4" style="margin:20px;">
        <label class="form-check-label" for="materialInline4">완결작</label>
        <input type="checkbox" class="form-check-input" id="materialInline5" style="margin:20px;">
        <label class="form-check-label" for="materialInline5">협업중</label>
    </div>

    {{-- 새 작품 추가  --}}
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="post-preview">
                <a href="{{url('editor/main/book_add')}}">
                    <h3 class="post-title" style="margin-top:30px; margin-bottom:30px;">
                        <img src="{{asset('image/plus.png')}}" alt="표지1" style="width:130px; height:150px;"
                            class="img-thumbnail">
                        작품추가
                    </h3>
            </div>

            <hr>

            {{-- 작품 출력 부분  --}}
            @foreach ($works as $row)
            <div class="post-preview">
                <a href="{{url('editor/main/chapter')}}/{{$row['num']}}">

                    <img src="{{$row['bookcover_of_work']}}" alt="표지1" style="width:130px; height:150px;" class="img-thumbnail" onerror="this.src='{{asset('image/no_image.png')}}'"/>

                    <div class="post-title" style="margin-top:30px; margin-bottom:30px; display:inline-flex;">
                        {{$row->work_title}}
                    </div>
                </a>
                <p class="post-meta">
                카테고리 : {{$row->tag}} <br>
                연재 종류 : @switch($row->type_of_work)
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
                연재 주기 :{{$row->cycle_of_publish}} <br>
                협업 멤버 : @foreach($nicknames as $name) {{$name->nickname}} @endforeach <br>
                구매 : {{$row->buy_price}}<br>
                대여 : {{$row->rental_price}}<br>
                최근 수정 시간 : {{$modify_time['updated_at']->diffForHumans()}}
                </p>

            </div>
            <hr>
            @endforeach

        </div>

    </div>
</div>

</body>

@endsection

@section('footer')
    @include('layouts.footer')
@endsection
