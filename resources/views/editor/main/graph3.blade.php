@extends('layouts.APP')

@section('content')
<script src="{{asset('js/graph3.js')}}" defer></script>
<div>
<table id="tabList" class="table table-bordered">
    {{-- <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">구매수</th>
        <th scope="col">구매수익</th>
        <th scope="col">대여수</th>
        <th scope="col">대여수익</th>
        <th scope="col">총수익</th>
        <th scope="col">정산수익</th>
      </tr>
    </thead> --}}
</table>
</div> 
@endsection