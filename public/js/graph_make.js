function hideExclude(excludeId) {
    $('#graph-box').children().each(function () {

        $(this).hide();
    });
    //넘겨 받은 id 요소는 show
    $("#" + excludeId).show();
}

$(document).ready(function () {

    $("#one-type").click(function () {
        hideExclude("chartdiv");
    });

    $("#bar-type").click(function () {
        hideExclude("chartdiv2");
    });

    $("#calculate").click(function () {
        hideExclude("chartdiv3");
    });

});

// $("#sidenav").click(function () {

//     var graphValue = $(this).val();

//     if ($('#one-type')) {

//         hideExclude("chartdiv");

//     } else if ($('#bar-type')) {
//         alert("test");
//         hideExclude("chartdiv2");

//     } else if ($('#calculate')) {
//         hideExclude("chartdiv3");
//     }

// });



// $("#one-type").click(function () {

//     $('#chartdiv').hideExclude();
//     $('#chartdiv2').hide();
//     $('#chartdiv3').hide();

// });

// $("#bar-type").click(function () {

//     $('#chartdiv2').hideExclude();
//     $('#chartdiv').hide();
//     $('#chartdiv3').hide();

// });

// $("#calculate").click(function () {

//     $('#chartdiv3').hideExclude();
//     $('#chartdiv2').hide();
//     $('#chartdiv').hide();

// });
