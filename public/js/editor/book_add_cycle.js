//text area 숨김
function hideExclude2(excludeId) {
    $('#changeTextArea_C').children().each(function () {

        $(this).hide();
    });
    //넘겨 받은 id 요소는 show
    $("#" + excludeId).show();
}

$(document).ready(function () {
    hideExclude2("change_w");

    var checkCnt = $("input:radio[name='radio_C']").is(":checked");
    if (checkCnt == 0) {
        $('#change_w').hide();
        $('#change_c').hide();

    }

    //radio chage 이벤트
    $("input[name=radio_C]").click(function () {

        var radioValue = $(this).val();

        if (radioValue == "2-1" || radioValue == "3-1") {
            hideExclude2("change_w");
        } else if (radioValue == "2-2" || radioValue == "3-2") {
            hideExclude2("change_c");
        }

        //radio chage 이벤트2
        $("input[name=radio_T]").click(function () {

            var radioValue = $(this).val();

            if (radioValue == "1") {
                $('#change_w').hide();
                $('#change_c').hide();
            } else if (radioValue == "2" || radioValue == "3") {
                $('#change_w').hide();
                $('#change_c').hide();
                $("input:radio[name=radio_C]").prop("checked", false);
            }
        });

    });



});
