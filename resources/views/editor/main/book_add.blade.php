@extends('layouts.master')

<script src="{{asset('js/book_add.js')}}" defer></script>
<script>
$(function() {
    $("#upload_file").on('change', function(){
        
        readURL(this);
    });
});
function readURL(input) {
    if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
        }
      reader.readAsDataURL(input.files[0]);
    }
}
</script>

@section('content')

  <!-- Main Content -->
  <div class="container" style="height:100%; background-color:#45b4e61a; margin-top:70px;">
    <!-- Material inline 1 -->
    <div class="form-check form-check-inline" style="width:100%; display: flex; justify-content: center;">

    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto" style="margin-top:50px; margin-bottom:50px;">
        <div class="container">

                        
            <div class="container register-form">
            <div class="form">

                <div class="form-content">
                                        
                    <div class="col-md-6">
                            <form action="{{action('WorkOut\IndexController@store')}}" method="post">
                                <input type='file' id="upload_file" name="bookcover_of_work"/>
                                <img id="blah" src="" alt="표지 추가" width="300" height="300" />
                    <div class="form-group">
                        제목<input type="text" class="form-control" name="work_title" placeholder="70자 이내" value="" style="width:400px;" />
                    </div>
                    <div class="form- group">
                        태그<input type="text" class="form-control" name="tag" placeholder="#로맨스 #판타지" value="" style="width:400px;"/><br>
                    </div>
                    <div class="form-group">
                        종류<br>
                            <label><input type="radio"  name="type_of_work" value="1" style="margin:10px;">회차</label>
                            <label><input type="radio" name="type_of_work" value="2" style="margin:10px;">단행본</label>
                            <label><input type="radio" name="type_of_work" value="3" style="margin:10px;">단편</label>
                    </div>
                    <div class="form-group">
                        가격<input type="text" class="form-control" name="rental_price" placeholder=" " value="" style="width:400px;"/>
                    </div>
                    <div class="form-group">
                        작품 소개<input type="text" class="form-control" name="introduction_of_work" placeholder="제한 없음" value="" style="width:400px; height:100px;"/>
                    </div>
                    <button type="submit" class="btnSubmit">등록</button>
                    <button type="button" class="btnSubmit" onclick="location.href='{{url('/')}}'">취소</button>
                            </form>
                    </div>
                </div>
            </div>
            </div>
        
            </div>
        
        </div>
        


      </div>
    </div>
  </div>

@endsection