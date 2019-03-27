@extends('layouts.master')
@section('content')

<!-- Main Content -->
<div class="container" style="background-color:#45b4e61a; margin-top:70px;">

    @if(\Auth::check())
    {{--  <p>{{ Auth::user() }}</p>  --}}
    <div>
        <a href="{{url('assets/upload')}}">asset upload</a>
    </div>
    @else 비 로그인 상태 @endif @if(Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif
    <div>
        {{Auth::user()['nickname']}}
    </div>
    {{--  정렬 필터링  --}}
    <input type="hidden" name="_token" value="{{ Session::token() }}">

    <!-- Material inline 1 -->
    <div class="form-check form-check-inline" style="width:100%; align-items: center; display: flex; justify-content: center;">
        <input type="checkbox" class="form-check-input" id="materialInline1" style="margin:20px;">
        <label class="form-check-label" for="materialInline1">회차</label>
        <input type="checkbox" class="form-check-input" id="materialInline2" style="margin:20px;">
        <label class="form-check-label" for="materialInline2">단행본</label>
        <input type="checkbox" class="form-check-input" id="materialInline3" style="margin:20px;">
        <label class="form-check-label" for="materialInline3">연재중</label>
        <input type="checkbox" class="form-check-input" id="materialInline3" style="margin:20px;">
        <label class="form-check-label" for="materialInline3">완결작</label>
        <input type="checkbox" class="form-check-input" id="materialInline3" style="margin:20px;">
        <label class="form-check-label" for="materialInline3">협업중</label>
    </div>

    {{--  새 작품 추가  --}}
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        <div class="post-preview">
            <a href="{{url('editor/main/book_add')}}">
            <h3 class="post-title" style="margin-top:30px; margin-bottom:30px;">
                <img src="{{asset('image/aaa.png')}}" alt="표지1" style="width:130px; height:150px;" class="img-thumbnail">
                작품추가
            </h3>
        </div>
        <hr>
    
    {{--  작품 출력 부분  --}}
    @foreach ($works as $row)
        <div class="post-preview">
        
        {{--  연재 종류가 회차인 경우 회차 리스트로 바로 이동
        @if ($row['type_of_work'] == 1)
            <a href="{{url('editor/main/list')}}">
        @else
            <a href="{{url('/')}}">
        @endif  --}}
            <a href="{{url('editor/main/chapter')}}/{{$row['num']}}">
              <img src="{{asset('image/logo.png')}}" alt="표지1" style="width:130px; height:150px;" class="img-thumbnail">
              <div class="post-title" style="margin-top:30px; margin-bottom:30px; display:inline-flex;">
              {{$row['work_title']}}
              </div>
            </a>
            <p class="post-meta">tag : <br>type : {{$row['type_of_work']}} <br>cycle :{{$row['cycle_of_publish']}} <br>member :  <br>price : {{$row['buy_price']}},{{$row['rental_price']}}<br>Modification time : {{$row['updated_at']}}</p>
            </div> 
            <hr>
    @endforeach

    </div>

            </div>
        </div>
        @endsection 