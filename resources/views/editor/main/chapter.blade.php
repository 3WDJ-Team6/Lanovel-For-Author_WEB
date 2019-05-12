@extends('layouts.master')


@section('head')
@include('layouts.head')

<script langauge="javascript">
    function popup(num) {
        var url = "/chapter_create/" + num;
        var option = "width=600, height=300, top=100"
        window.open(url, "", option);
    }

</script>
<script>
    // function receiver() {
    //     document.
    // }

</script>
@endsection

@section('header')
@include('layouts.header')
@endsection

@section('content')

<!-- Main Content -->
<div class="container" style="background-color:#45b4e61a; margin-top:70px;">
    @if(Session::has('success'))
    <div class="alert alert-info">{{ Session::get('success') }}</div>
    @endif
    <!-- Material inline 1 -->
    <div class="form-check form-check-inline"
        style="width:100%; align-items: center; display: flex; justify-content: center;"></div>

    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto" id="chapters_box" style="margin-top:50px; margin-bottom:50px;">
            <div id="work_title_box" style="margin-bottom:50px;">
                <h4 style="margin-bottom:20px;"><a href="/" style="text-decoration:none;">{{$nowWork->work_title}}</a>
                </h4>
                <p>{{$nowWork->introduction_of_work}}</p>
            </div>

            <div class="post-preview">
                <h3 class="post-subtitle">
                    <img src="{{asset('image/plus.png')}}" alt="표지1" style="width:130px; height:130px;"
                        class="img-thumbnail">

                    <a href="javascript:popup({{$num}})" target="_blank" style="text-decoration:none;">챕터 추가</a>
                </h3>
            </div>
            <hr>


            @foreach($works as $row)

            @foreach($checkNum as $cn)
            @if($row->num == $cn->num)
            <div class="post-preview">
                <a href="{{url('editor/main/list')}}/{{$row['num']}}" style="text-decoration:none;">

                    <img src="{{asset('image/book.png')}}" alt="표지1" style="width:130px; height:130px;"
                        class="img-thumbnail">
                    <h3 class="post-subtitle" style="display:inline-block">
                        {{$row->subtitle}}
                    </h3>
                    @if($cn->subsubtitle)
                    <a href="{{url('publication')}}/{{$row['num_of_work']}}/{{$row['num']}}"
                        style="text-decoration:none; float:right; margin-top: 60px;"> 발행</a>
                </a>
                <p class="post-meta">Posted by sunsilver on May 5th</p>
            </div>

            <hr>
            @break
            @endif
            @endforeach
            @endforeach

            <!-- Pager -->

        </div>
    </div>
</div>

@endsection


@section('footer')
@include('layouts.footer')
@endsection
