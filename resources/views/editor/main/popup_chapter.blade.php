<!-- Bootstrap core CSS -->
<link href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">

<script language="Javascript">
    function frameclose() {
        parent.close()
        window.close()
        self.close()
    }
</script>


<div class="container register-form">

    <div class="form-content">
        <div class="col-md-6">
            <form action="{{url('addChapter')}}/{{$num}}" method="post">
                <div class="form-group">
                    챕터<input type="text" class="form-control" placeholder="" value="" name="subtitle" style="width:400px;" />
                </div>

                <button type="submit" class="btnSubmit">추가</button>
                <button type="button" class="btnSubmit" onclick="location.href='javascript:frameclose()'">취소</button>
            </form>
        </div>
    </div>

</div> 