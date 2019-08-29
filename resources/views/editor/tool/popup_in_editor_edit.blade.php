<!-- Bootstrap core CSS -->
<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

<script language="Javascript">
    function frameclose() {
        parent.close();
        window.close();
        self.close();
    }

</script>
<style>
    .btnSubmit {
        border-radius: 3px;
        border: 0;
        background-color: #ea5254;
        color: white;
        width: 120px;
        height: 40px;
    }

    .holine {
        width: 93%;
        border: 2px solid #d8d8d8;
        position: absolute;
        margin: 0;
    }

    .logo {
        padding-bottom: 10px;
    }

    .btn_list {
        margin-left: 46%;
    }

    .list_title {
        margin-top: 5%;
    }

    .form-control {
        width: 476px;
        margin-top: 9%;
    }

    .closed {
        position: absolute;
        top: 7px;
        right: 20px;
        display: block;
        width: 40px;
        height: 40px;
    }

</style>


<div class="container register-form">

    <div class="form-content">
        <form action="{{url('editContentInEditor')}}/{{$content_data['num']}}" method="post">
            <div class="col-md-6">
                <div class="form-group">
                    <h3 class='list_title'>
                        <img src='../../../image/logo_book.png' class='logo'>
                        <b style='position:absolute;'>&nbsp;List</b>
                        <img src='../svg/closed_icon.svg' class="closed">
                    </h3>
                    <hr class="holine">
                    <input type="text" class="form-control" value="{{$content_data['subsubtitle']}}"
                        name="subsubtitle" />
                </div>
                <div class="btn_list">
                    <button type="submit" style="margin-right:5%;" class="btnSubmit">修正</button>
                    <button type="button" class="btnSubmit"
                        onclick="location.href='javascript:frameclose()'">キャンセル</button>
                </div>
            </div>
        </form>
    </div>

</div>
