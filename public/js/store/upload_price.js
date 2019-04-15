//text area 숨김
function hideExclude(excludeId) {
    $('#paid_form').children().each(function () {

        $(this).hide();
    });
    //넘겨 받은 id 요소는 show
    $("#" + excludeId).show();
}

$(document).ready(function () {
    var checkCnt = $("input:radio[name='radio_P']").is(":checked");
    if (checkCnt == 0) {
        $('#paid_form').hide();
    }

    //radio chage 이벤트
    $("input[name=radio_P]").click(function () {

        var radioValue = $(this).val();

        if (radioValue == "paid") {
            hideExclude("paid_form");
        }

    });

    $("input[name=radio_P]").click(function () {

        var radioValue = $(this).val();

        if (radioValue == "free") {
            $('#paid_form').hide();
        }

    });
})
