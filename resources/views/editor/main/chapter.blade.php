@extends('layouts.master')

@section('head')
@include('layouts.head')
@endsection

@section('header')
@include('layouts.header')
@endsection

@section('content')
<script langauge="javascript">
    function popup(num) {
        var url = "/chapter_create/" + num;
        var option = "width=600, height=300, top=100"
        window.open(url, "", option);
    }

</script>

<!-- Main Content -->
<div class="container" style="background-color:#45b4e61a; margin-top:70px;">

    <!-- Material inline 1 -->
    <div class="form-check form-check-inline"
        style="width:100%; align-items: center; display: flex; justify-content: center;"></div>

    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto" id="chapter_box" style="margin-top:50px; margin-bottom:50px;">
            <div class="container">
                <h3>동무
                    <h6>「 밑바닥부터 시작해서 대통령이 됬더니 사고로 공산주의국가에서 환생하는 이야기 」
            </div>
            <div class="post-preview">
                <h3 class="post-subtitle">
                    <img src="{{asset('image/plus.png')}}" alt="표지1" style="width:130px; height:130px;"
                        class="img-thumbnail">
                    <a href="javascript:popup({{$num}})" target="_blank">챕터 추가</a>
                </h3>
            </div>
            <hr>
            @foreach($works as $row)
            <div class="post-preview">
                <a href="{{url('editor/main/list')}}/{{$row['num']}}">
                    <h3 class="post-subtitle">
                        <img src="{{asset('image/book.png')}}" alt="표지1" style="width:130px; height:130px;"
                            class="img-thumbnail">

                        {{$row['subtitle']}}
                    </h3>
                </a>
                <p class="post-meta">Posted by sunsilver on May 5th</p>
            </div>
            <hr>
            @endforeach

            <!-- Pager -->

        </div>
    </div>
</div>




</div>
</div>
</div>

@endsection

@section('footer')
@include('layouts.footer')
@endsection
