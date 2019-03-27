$(function () {
    $("#datepicker").datepicker();
    $("#anim").on("datechange", function () {
        $("#datepicker").datepicker("option", "showAnim", $(this).val());
    });
});
