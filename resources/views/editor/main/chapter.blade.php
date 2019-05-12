@extends('layouts.master')

@section('head')
@include('layouts.head')
<style>
    body {
        font-family: 'M PLUS Rounded 1c';
    }

</style>
<link href="https://fonts.googleapis.com/css?family=M+PLUS+Rounded+1c" rel="stylesheet">
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
<div class="container" style="margin-top:70px;">
    @if(Session::has('success'))
    <div class="alert alert-info">{{ Session::get('success') }}</div>
    @endif
    <!-- Material inline 1 -->
    <div class="form-check form-check-inline"
        style="width:100%; align-items: center; display: flex; justify-content: center;"></div>

    <div class="row">
        <div class="col-lg-12 col-md-10 mx-auto" id="chapters_box" style="margin-top:50px; margin-bottom:50px;">
            <div id="work_title_box" style="margin-bottom:50px;">
                <h4 style="margin-bottom:20px;"><a href="/" style="text-decoration:none;">{{$nowWork->work_title}}</a>
                </h4>
                <p>{{$nowWork->introduction_of_work}}</p>
            </div>
            <div class="chapter" style="align-items; center; display: flex; justify-content: center;">
            <div class="post-preview" style=" display:inline-block; margin:2%; ">
                <h4 class="post-subtitle" style="border:2px solid #9DCFFF; border-radius:10px; width:315px; height:315px; align-items; display: flex; justify-content: center;">
                    

                    <a href="javascript:popup({{$num}})" target="_blank" style="display:block; color:black; text-decoration:none;">
                    <img src="{{asset('image/plus.png')}}" alt="표지1"
                        style="width:130px; height:130px; margin:2%; margin-top:50%; display:block;" class="img-thumbnail">챕터
                        추가</a>
                </h4>
            </div>

            @foreach($works as $row)

            @foreach($checkNum as $cn)
            @if($row->num == $cn->num)
            <div class="post-preview" style="display: flex; justify-content: center; align-items; center; text-aligns:center; border-radius:10px; border:2px solid #9DCFFF; width:320px; height:320px; display:block; margin:2%;">
                <a href="{{url('editor/main/list')}}/{{$row['num']}}" style="text-decoration:none;">

                    <img src="{{asset('image/note.png')}}" alt="표지1"
                        style="width:150px; height:200px; display:block; margin-left:25%; margin-top:5%; margin-bottom:5%; box-shadow: 10px 10px 10px -5px rgba(0, 0, 0, 1);" class="img-thumbnail">
                    <h5 class="post-subtitle" style="display:inline-block; display: flex; justify-content: center; align-items; center;">
                        {{$row->subtitle}}
                    </h5>
                    
                </a>
                <p class="post-meta" style="font-size:15px; display:flex; margin-left:2%; margin:0; justify-content: center; align-items; center;">Posted by sunsilver on May
                    5th</p>
                    @if($cn->subsubtitle)
                    <a href="{{url('publication')}}/{{$row['num_of_work']}}/{{$row['num']}}"
                        style="text-decoration:none; float:right; display:block; margin-right:2%;"> 발행</a>
                    @endif
            </div>

            @break
            @endif
            @endforeach
            @endforeach
    </div>
            <!-- Pager -->

        </div>
    </div>
</div>

@endsection


@section('footer')
@include('layouts.footer')
@endsection
