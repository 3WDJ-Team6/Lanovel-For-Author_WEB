// $(document).ready(function(){
//     $("#one-type").click(function(){
//           $('.graph-box').append('그래프');
//     });
//   });
$(document).ready(function(){

  function hideExclude＿graph(excludeId) {
    $('#graph-box').children().each(function () {

        $(this).hide();
    });
    //넘겨 받은 id 요소는 show
    $("#" + excludeId).show();
}

  $("#one-type").click(function(){

        $('#chartdiv').hideExclude();
        $('#chartdiv2').hide();
        $('#chartdiv3').hide();
        
  });


  // $("#sidenav").click(function(){
    
  //   var graphValue = $(this).val();

  //   if(graphValue == "one") {
  //       hideExclude("chartdiv");
  //   }else if(graphValue == "bar") {
  //       hideExclude("chartdiv2");
  //   }else if(graphValue == "calculate") {
  //       hideExclude("chartdiv3");
  //   }

});
  $("#bar-type").click(function(){

    if($('div').hasClass('chartdiv')){
        $('#chartdiv').hide();
    }

      $('#chartdiv2').toggle();
      $('#chartdiv1').hide();
      $('#chartdiv3').hide();

});

  $("#calculate").click(function(){
    if($('div').hasClass('chartdiv')){
      $('#chartdiv').hide();
  }

      $('#chartdiv3').toggle();
      $('#chartdiv1').hide();
      $('#chartdiv2').hide();
  });



