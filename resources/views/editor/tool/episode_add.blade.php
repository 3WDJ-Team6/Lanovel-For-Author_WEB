@extends('layouts.app')

@section('content')
<form action="">
    @csrf
    에피소드 제목 추가
    <input type="text" name="" id="">
    <input type="button" class="win-close" value="추가">
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $('.win-close').click(function(){
            window.close();
        });
    });
</script>
@endsection
