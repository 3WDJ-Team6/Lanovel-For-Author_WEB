$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    $(document).on("keyup", "input[type='text']", function () {
        var k = $(this).val();
        $("#userlists > .userlist").hide();
        // $(".userlist_li:contains('" + k + "')").hide();
        // alert("test");
        // var temp = $(".userlist_li:contains('" + k + "')");
        // $("#userlist").show();
        $("#userlists > div > a > #info > div:contains('" + k + "')").parent().parent().parent().show();
        if (k.length == 0) {
            $("#userlists > .userlist").hide();
        }
    })
    $(document).on(function () {
        function load() {
            $("#alramimg").parent().show();
        }
    })
    var html = '';
    $(document).on('click', '#submitbtn', function () {
        var str = $("#sample_form").serialize();
        Str = str.split("&");
        Str[0] = decodeURIComponent(Str[0].replace('userid=', ''));
        Str[1] = Str[1].replace('numofwork=', '');
        Str[2] = decodeURIComponent(Str[2].replace('message=', ''));
        console.log(Str[0]);
        console.log(Str[1]);
        console.log(Str[2]);
        $.ajax({
            url: '/sendInviteMessage',
            method: "post",
            data: {
                usernickname: Str[0],
                numofwork: Str[1],
                message: Str[2]
            },
            success: function () {
                $('.jquery-modal1').css('display', 'none');
                // $('#member_list').append("<div class='member_list_li'>&nbsp;초보그림쟁이</div>");
            },
            error: function (e) {
                console.log(e);
            }
        })
    });
});
