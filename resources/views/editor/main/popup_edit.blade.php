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
    <form action="{{url('editContent')}}/{{$content_data['num']}}" method="post">
        <div class="col-md-6">
            <div class="form-group">
                목차<input type="text" class="form-control" value="{{$content_data['subsubtitle']}}" name="subsubtitle" style="width:400px;" />
            </div>
            <button type="submit" class="btnSubmit">수정</button>
            <button type="button" class="btnSubmit" onclick="location.href='javascript:frameclose()'">취소</button>
        </div>
        </form>
    </div>

</div>
