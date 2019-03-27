@extends('layouts.master')

@section('content')

<script langauge="javascript">
    function popup(num) {
        var url = "/content_create/" + num;
        var option = "width=600, height=300, top=100"
        window.open(url, "", option);
    }
</script>

<!-- Main Content -->
<div class="container" style="background-color:#45b4e61a; margin-top:70px;">
    <!-- Material inline 1 -->
    <div class="form-check form-check-inline" style="width:100%; align-items: center; display: flex; justify-content: center;"></div>

    <div class="row">

   
        <div class="col-lg-8 col-md-10 mx-auto" style="margin-top:50px; margin-bottom:50px;">
            <!-- {{-- 새 회차 추가  --}} -->
            <div class="post-preview">
                <h3 class="post-subtitle">
                    <a href="javascript:popup({{$num}})" target="_blank">목차 추가</a>
                </h3>
            </div>
            <hr>

            <!-- {{-- 회차 출력 부분  --}} -->
            @foreach($chapter_of_works as $row)
            <div class="post-preview">
                <a href="{{url('editor/tool/editor')}}/{{$row['num']}}">
                    <h3 class="post-subtitle">
                        {{$row['subsubtitle']}}
                    </h3>
                </a>
                <p class="post-meta">Posted by sunsilver on {{$row['created_at']}}</p>
            </div>
            <hr>
            @endforeach



            <!-- Pager -->

        </div>
    </div>
</div>

@endsection 