$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    $(document).on("keyup", "input[type='text']", function () {
        var k = $(this).val();
        $("#userlists > .userlist").hide();
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
        Str[3] = decodeURIComponent(Str[3].replace('p_p=', ''));
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
                $('#member_list').append("<div class='member_list_li'><img class='member_profile_icon' src='" + Str[3] + "'>&nbsp;" + Str[0] + "</div>");
            },
            error: function (e) {
                console.log(e);
            }
        })
    });

    $(document).on('click', '#viewMessage', function () {
        num = document.getElementById('viewMessage').className;
        $.ajax({
            url: '/viewMessage/' + num,
            method: "post",
            data: {
                num: num
            },
            success: function (result) {
                jQuery("#w3-modal-content").html(result);
            },
            error: function (e) {
                console.log(e);
            }
        })
    });
    $(document).on('click', '#viewMessage', function () {
        num = document.getElementById('viewMessage').className;
        $.ajax({
            url: '/viewMessage/' + num,
            method: "post",
            data: {
                num: num
            },
            success: function (result) {
                jQuery("#w3-modal-content").html(result);
            },
            error: function (e) {
                console.log(e);
            }
        })
    });
});
