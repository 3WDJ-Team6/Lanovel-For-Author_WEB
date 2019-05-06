function hideExclude(excludeId) {
    $('#graph-box').children().each(function () {

        $(this).hide();
    });
    //넘겨 받은 id 요소는 show+
    $("#" + excludeId).show();
}

$(document).ready(function () {

    $('#chartdiv2').hide();

    $("#first").click(function () {
        hideExclude("chartdiv");
    });

    $("#second").click(function () {
        hideExclude("chartdiv2");
    });



});
