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
        // console.log(document.getElementById('message_for_invite').value);
        // console.log(target_nickname);
        // console.log(num_of_work);
        // var form = $('#sample_form')[0];
        // formData = new FormData(form);
        // formData.append("#")
        var str = $("#sample_form").serialize();
        Str = str.split("&");
        Str[0] = Str[0].replace('userid=', '');
        Str[1] = Str[1].replace('numofwork=', '');
        Str[2] = Str[2].replace('message=', '');
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
                $('#member_list').append("<div class='member_list_li'>&nbsp;" + Str[0] + "</div>");
            },
            error: function (e) {
                console.log(e);
            }
        })
    });
});
