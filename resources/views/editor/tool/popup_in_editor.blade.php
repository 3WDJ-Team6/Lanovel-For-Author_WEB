<!-- Bootstrap core CSS -->
<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

<script language="Javascript">
    function frameclose() {
        parent.close()
        window.close()
        self.close()
    }
</script>


<div class="container register-form">

    <div class="form-content">
        에디터 안에서 목차 추가하는거임
        <form action="{{url('addContent')}}/{{$num}}" method="post" id="addContentForm"> 
            <div class="col-md-6">
                <div class="form-group">
                    목차<input type="text" class="form-control" placeholder="" name="subsubtitle" style="width:400px;" />
                </div>
                <button type="submit" class="btnSubmit">추가</button>
                <button type="button" class="btnSubmit" onclick="location.href='javascript:frameclose()'">취소</button>
            </div>
        </form>
    </div>

</div> 