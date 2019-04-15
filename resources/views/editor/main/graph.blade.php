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
        style="width:100%; align-items: center; display: flex; justify-content: center;"></div>

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
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin:20px;">
                태그
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#">태그1 </a>
                <a class="dropdown-item" href="#">태그2</a>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        var work_arrays = <?php echo json_encode($work_arrays); ?>;
        var date_arrays = <?php echo json_encode($date_arrays); ?>;
        
        // var array = arrays.replace(/&quot;/g,"'"); 
        // var arr = JSON.parse(array);
        // console.log(JSON.stringify(arrays, null, 2));
        
        // var array = arrays.replace(/&quot;/g,"'");
        // var arr = JSON.parse(arrays);
        console.log(work_arrays);
        console.log(date_arrays);
        
        // console.log([[{'num':1,'work_title':'작품1','status_of_work':1,'type_of_work':1,'rental_price':200,'buy_price':1000},{'num':3,'work_title':'testtest','status_of_work':1,'type_of_work':1,'rental_price':500,'buy_price':1000},{'num':4,'work_title':'ㅇㅇ','status_of_work':1,'type_of_work':3,'rental_price':null,'buy_price':1000},{'num':5,'work_title':'커비','status_of_work':1,'type_of_work':1,'rental_price':1000,'buy_price':1000},{'num':6,'work_title':'진짜_재밌는_책','status_of_work':1,'type_of_work':1,'rental_price':123,'buy_price':123},{'num':7,'work_title':'ㅇㅇ','status_of_work':1,'type_of_work':1,'rental_price':123,'buy_price':1000},{'num':8,'work_title':'깨비깨비도깨비','status_of_work':1,'type_of_work':1,'rental_price':1000000,'buy_price':10000000}],[{'num_of_work':1,'count':2},{'num_of_work':3,'count':1}],[{'num_of_work':1,'count':4}]]);

        var work_profit = new Array();
        for(var i in work_arrays){
            // console.log(work_arrays[i].work_title);
            // console.log(work_arrays[i].rental_price);
            // console.log(work_arrays[i].buy_price);
            work_profit[i] = {
                "title": work_arrays[i].work_title,
                "profit": work_arrays[i].rental_price * work_arrays[i].ren + work_arrays[i].buy_price * work_arrays[i].buy
            };
        }
         console.log(work_profit);

         var date_profit = new Array();

         
         for(var i in date_arrays){
            date_profit[i] = {
                "date": date_arrays[i].onlyDate,
                "profit": date_arrays[i].rental_price * date_arrays[i].ren + date_arrays[i].buy_price * date_arrays[i].buy
            };
         }
         console.log(date_profit);
         
        </script>


    <script>

    var workArray = <?php echo json_encode($workArray); ?>;
    for(int i=0; i<workArray.length; i++){
    var data[];
        data+= workArray[i];
    }
    </script>
    

    <script src="https://www.amcharts.com/lib/4/core.js"></script>
    <script src="https://www.amcharts.com/lib/4/charts.js"></script>
    <script src="https://www.amcharts.com/lib/4/themes/frozen.js"></script>
    <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

    <script src="{{ asset('js/graph.js') }}" defer></script>
    <script src="{{ asset('js/graph_make.js') }}" defer></script>
    <script src="{{ asset('js/graph2.js') }}" defer></script>
    <script src="{{ asset('js/graph3.js') }}" defer></script>
</div>
</div>

@endsection

@section('footer')
@include('layouts.footer')
@endsection