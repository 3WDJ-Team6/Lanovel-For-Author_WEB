<!-- Bootstrap core CSS -->
<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
<script src="{{asset('bower_components\jquery\dist\jquery.js')}}"></script>
<script language="Javascript">
    function frameclose() {
        parent.close()
        window.close()
        self.close()
    }
</script>



<div class="container register-form">

    <div class="form-content">
        <form action="{{url('addContent')}}/{{$num}}" method="post" id="addContentForm" name="contentcontent"> 
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

<!-- ajax 부분 -->
<!-- <script type="text/javascript">

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#addContentForm").submit(function(e) {
        // console.log(e);
        
        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        // console.log(form);
        var url = form.attr('action');
        // console.log(url);
        
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // data 값을 controller로 전송 -> 이 값을 받은 컨트롤러에서 조작이 끝나면
            error: function(){
                throw new error("실패");
            },
            success: function(controller)   // 성공했다면 이 함수를 실행시키겠다 controller에서 return받은 data로.
            {
               makeTag(controller);   // return 받은 데이터를 가지고 작업을 하면 됨.
            }
            });
        });

        function send(){
            document.contentcontent.text
        }
        function makeTag(data){
            var tag = "";

            var chapter = data;
            // chapter = !chapter.length ? [chapter] : chapter;
            
            if (chapter) {
                console.log(chapter);
                tag +=
                    "<div class='post-preview'>" +
                    "<a href='/editor/main/list/" + chapter.num + "'>" +
                    "<h3 class='post-subtitle'>" +
                    "<img src='image/book.png'" + "alt='표지1' style='width:130px; height:130px;' class='img-thumbnail'>" +
                    chapter.subtitle +
                    "</h3>" + 
                    "</a>" + 
                    "<p class='post-meta'>" + "ajax test" + "</p>" + 
                    "</div>" + 
                    "<hr>";
            }
            console.log(tag);
            
            $('#chapter_box').html(tag);
        }

        

</script> -->