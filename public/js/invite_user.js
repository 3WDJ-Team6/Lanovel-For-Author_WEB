// $(document).on("change", "input[type='text']", function () {
//     $(".userlist_li").show();
//     console.log("리시트쇼");

$(document).on("keyup", "input[type='text']", function () {

    var k = $(this).val();
    $("#userlists > a").hide();
    // $(".userlist_li:contains('" + k + "')").hide();
    console.log(k.length);
    console.log(k);
    // var temp = $(".userlist_li:contains('" + k + "')");
    // $("#userlist").show();
    $("#userlists > a > div:contains('" + k + "')").parent().show();
    if (k.length == 0) {
        $("#userlists > a").hide();
    }
})
// });

// 특정 값만 보이고 특정 값은 보이지 않는 리스트를 띄워야 되는데 이게 안됨.
// jquery에서 받아오는 id값이나 class 값을 적당히 조절
