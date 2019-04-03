//text area 숨김
function hideExclude(excludeId) {
    $('#changeTextArea_T').children().each(function () {

        $(this).hide();
    });
    //넘겨 받은 id 요소는 show
    $("#" + excludeId).show();
}

$(document).ready(function () {
    // hideExclude("change1");

    // 체크 되어 있는지 확인
    var checkCnt = $("input:radio[name='radio_T']").is(":checked");
    if (checkCnt == 0) {
        $('#change1').hide();
        $('#change2').hide();
        $('#change3').hide();
    }
    //fdfd

    //radio chage 이벤트
    $("input[name=radio_T]").click(function () {

        var radioValue = $(this).val();

        if (radioValue == "1") {
            hideExclude("change1");
            hideExclude("rent");
        } else if (radioValue == "2") {
            hideExclude("change2");
        } else if (radioValue == "3") {
            hideExclude("change3");
        }

    });

    $("input[name=radio_T]").click(function () {

        var radioValue = $(this).val();

        if (radioValue == "3") {
            $('#rent').hide();
        }

    });
});

