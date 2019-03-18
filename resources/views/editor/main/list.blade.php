@extends('layouts.master')

@section('content')

  <!-- Main Content -->
  <div class="container" style="background-color:#45b4e61a; margin-top:70px;">
    <!-- Material inline 1 -->
    <div class="form-check form-check-inline" style="width:100%; align-items: center; display: flex; justify-content: center;"></div>

    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto" style="margin-top:50px; margin-bottom:50px;">
        <div class="post-preview" >
          <a href={{url('editor/tool/editor')}}>
            <h3 class="post-subtitle">
                프롤로그
            </h3>
          </a>
          <p class="post-meta">Posted by sunsilver on March 18, 2019</p>
        </div>
        <hr>
        <div class="post-preview">
          <a href={{url('editor/tool/editor')}}>
            <h3 class="post-subtitle">
                목차1. 혜은이와 아이들
            </h3>
          </a>
          <p class="post-meta">Posted by sunsilver on March 18, 2019</p>
        </div>
        <hr>
        <div class="post-preview">
          <a href={{url('editor/tool/editor')}}>
            <h3 class="post-subtitle">
                목차2. 혜은이와 은채
            </h3>
          </a>
          <p class="post-meta">Posted by sunsilver on March 18, 2019</p>
        </div>
        <hr>
        <div class="post-preview">
          <a href={{url('editor/tool/editor')}}>
            <h3 class="post-subtitle">
                목차3. 혜은이와 홍기
            </h3>
          </a>
          <p class="post-meta">Posted by sunsilver on March 18, 2019</p>
        </div>
        <hr>
        <div class="post-preview">
          <a href={{url('editor/tool/editor')}}>
            <h3 class="post-subtitle">
                목차3. 혜은이와 민수
            </h3>
          </a>
          <p class="post-meta">Posted by sunsilver on March 18, 2019</p>
        </div>
        <hr>
        <div class="post-preview">
          <a href={{url('editor/tool/editor')}}>
            <h3 class="post-subtitle">
                목차2. 혜은이와 은광이와 형진이
            </h3>
          </a>
          <p class="post-meta">Posted by sunsilver on March 18, 2019</p>
        </div>

       

        <!-- Pager -->

      </div>
    </div>
  </div>

@endsection