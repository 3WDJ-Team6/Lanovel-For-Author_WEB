@extends('layouts.master')

@section('content')


  <!-- Main Content -->
  <div class="container" style="background-color:#45b4e61a; margin-top:70px;">
    <!-- Material inline 1 -->
<div class="form-check form-check-inline" style="width:100%; align-items: center; display: flex; justify-content: center;">
  <input type="checkbox" class="form-check-input" id="materialInline1" style="margin:20px;" >
  <label class="form-check-label" for="materialInline1">회차</label>
    <input type="checkbox" class="form-check-input" id="materialInline2" style="margin:20px;">
    <label class="form-check-label" for="materialInline2">단행본</label>
    <input type="checkbox" class="form-check-input" id="materialInline3" style="margin:20px;">
    <label class="form-check-label" for="materialInline3">연재중</label>
    <input type="checkbox" class="form-check-input" id="materialInline3" style="margin:20px;">
    <label class="form-check-label" for="materialInline3">완결작</label>
    <input type="checkbox" class="form-check-input" id="materialInline3" style="margin:20px;">
    <label class="form-check-label" for="materialInline3">협업중</label>

    <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin:20px;">
      정렬방식
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      <a class="dropdown-item" href="#">최근 수정 순 </a>
      <a class="dropdown-item" href="#">마감일 순</a>
    </div>
  </div>
</div>

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
          <div class="post-preview">
          <a href="{{url('editor/main/list')}}">
            <h3 class="post-title" style="margin-top:30px; margin-bottom:30px;">
              <img src="{{asset('image/logo.png')}}" alt="표지1" style="width:130px; height:150px;" class="img-thumbnail">
              작품1
            </h3>
            <h4 class="post-subtitle">
              Problems look mighty small from 150 miles up
            </h4>
          </a>
          <p class="post-meta">Posted by
            <a href="{{url('editor/main/graph')}}">Start Bootstrap</a>
            on September 24, 2019</p>
        </div>
        <hr>
        <div class="post-preview">
          <a href={{url('editor/main/list')}}>
            <h3 class="post-title" style="margin-top:30px; margin-bottom:30px;">
              <img src="{{asset('image/logo.png')}}" alt="표지1" style="width:130px; height:150px;" class="img-thumbnail">
              작품2
            </h3>
            <h4 class="post-subtitle">
              Problems look mighty small from 150 miles up
            </h4>
          </a>
          <p class="post-meta">Posted by
            <a href="#">Start Bootstrap</a>
            on September 24, 2019</p>
        </div>
        <hr>
        <div class="post-preview">
          <a href={{url('editor/main/list')}}>
            <h3 class="post-title" style="margin-top:30px; margin-bottom:30px;">
              <img src="{{asset('image/logo.png')}}" alt="표지1" style="width:130px; height:150px;" class="img-thumbnail">
              작품3
            </h3>
            <h4 class="post-subtitle">
              Problems look mighty small from 150 miles up
            </h4>
          </a>
          <p class="post-meta">Posted by
            <a href="#">Start Bootstrap</a>
            on September 24, 2019</p>
        </div>

       

        <!-- Pager -->

      </div>
    </div>
  </div>


  @endsection