@extends('layouts.master')

@section('head')
    @include('layouts.head')
    <script src="{{asset('js/jquery/jquery.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/graph.css')}}">
@endsection

@section('header')
    @include('layouts.header')
@endsection

@section('content')

<!-- Main Content -->
<div class="container" style="background-color:#45b4e61a; margin-top:70px; height:700px;">
    <!-- Material inline 1 -->
    <div class="form-check form-check-inline"
        style="width:100%;s align-items: center; display: flex; justify-content: center;"></div>
    <div class="row">
        <div id="sidenav" style="margin-top:20px;">
            <span class="btn" id="one-type" name="graph" value="one">작품별 수익</span>
            <hr>
            <span class="btn" id="bar-type" name="graph" value="bar">날짜별 수익</a></span>
            <hr>
            <span class="btn" id="calculate" name="graph" value="calculate">정산</a></span>
        </div>

        <div class="col-lg-8 col-md-10 mx-auto">
            <form style="display: flex; justify-content: center;">
                <label class="checkbox-inline">
                    <input type="checkbox" value="" style="margin:10px;">완결작
                </label>
                <label class="checkbox-inline">
                    <input type="checkbox" value="" style="margin:10px;">연재중
                </label>
            </form>
            <form style="display: flex; justify-content: center;">
                <label class="checkbox-inline">
                    <input type="checkbox" value="" style="margin:10px;">회차
                </label>
                <label class="checkbox-inline">
                    <input type="checkbox" value="" style="margin:10px;">단편
                </label>
                <label class="checkbox-inline">
                    <input type="checkbox" value="" style="margin:10px;">단행본
                </label>
            </form>

            <div class="graph-box" id="graph-box" name="graph" style="width:700px; height:400px;">
                <div id="chartdiv" class="chartdiv"></div>
                <div id="chartdiv2" class="chartdiv2"></div>
                <div id="chartdiv3" class="chartdiv3"></div>
            </div>
        </div>

        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin:20px;">
                태그
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#">태그1 </a>
                <a class="dropdown-item" href="#">태그2</a>
            </div>
        </div>
    </div>
    <script src="https://www.amcharts.com/lib/4/core.js"></script>
    <script src="https://www.amcharts.com/lib/4/charts.js"></script>
    <script src="https://www.amcharts.com/lib/4/themes/frozen.js"></script>
    <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
    <script src="{{ asset('js/editor/graph.js') }}" defer></script>
    <script src="{{ asset('js/editor/graph_make.js') }}" defer></script>
    <script src="{{ asset('js/editor/graph2.js') }}" defer></script>
    <script src="{{ asset('js/editor/graph3.js') }}" defer></script>

</div>
</div>

@endsection

@section('footer')
    @include('layouts.footer')
@endsection