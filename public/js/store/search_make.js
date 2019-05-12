function hideExclude(excludeId) {
    $('#find').children().each(function () {

        $(this).hide();
    });
    //넘겨 받은 id 요소는 show+
    $("#" + excludeId).show();
}

$(document).ready(function () {


    $('#find_price').hide();
    $('#find_detail').hide();

    $("#tag").click(function () {
        hideExclude("find_tag");
    });

    $("#price").click(function () {
        hideExclude("find_price");
    });

    $("#detail").click(function () {
        hideExclude("find_detail");
    });

});
