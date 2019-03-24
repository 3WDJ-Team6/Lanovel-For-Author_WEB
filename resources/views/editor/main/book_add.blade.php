@extends('layouts.master')

@section('content')

  <!-- Main Content -->
  <div class="container" style="background-color:#45b4e61a; margin-top:70px;">
    <!-- Material inline 1 -->
    <div class="form-check form-check-inline" style="width:100%; align-items: center; display: flex; justify-content: center;"></div>

    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto" style="margin-top:50px; margin-bottom:50px;">
        <div class="container">

                        
            <div class="container register-form">
            <div class="form">

                <div class="form-content">
                                        
                    <div class="col-md-6">
                            <form action="/action_page.php">
                                <input type="file" name="pic" accept="image/*" style="margin-bottom:10px;">
                              </form>
                        <div class="form-group">
                            제목<input type="text" class="form-control" placeholder="70자 이내" value="" style="width:400px;" />
                        </div>
                        <div class="form- group">
                            태그<input type="text" class="form-control" placeholder="태그 당 10자 이내" value="" style="width:400px;"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            종류<input type="text" class="form-control" placeholder=" " value="" style="width:400px;"/>
                        </div>
                        <div class="form-group">
                            가격<input type="text" class="form-control" placeholder=" " value="" style="width:400px;"/>
                        </div>
                        <div class="form-group">
                            작품 소개<input type="text" class="form-control" placeholder="제한 없음" value="" style="width:400px; height:100px;"/>
                        </div>
                    </div>
                </div>
                    <button type="button" class="btnSubmit" onclick="location.href='{{url('/')}}'">등록</button>
                    <button type="button" class="btnSubmit" onclick="location.href='{{url('/')}}'">취소</button>
            </div>
            </div>
        
            </form>
            </div>
        
        </div>
        

       

        <!-- Pager -->

      </div>
    </div>
  </div>

@endsection