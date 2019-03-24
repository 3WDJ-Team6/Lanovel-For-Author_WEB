// $(document).ready(function(){
//     $("#one-type").click(function(){
//           $('.graph-box').append('그래프');
//     });
//   });
$(document).ready(function(){
  $("#one-type").click(function(){
        if($('div').hasClass('chartdiv2')){
            $('.chartdiv2').hide();
        }
        $('.chartdiv').toggle();
  });
});

$(document).ready(function(){
    $("#bar-type").click(function(){
        if($('div').hasClass('chartdiv')){
            $('.chartdiv').hide();
        }
          $('#chartdiv2').toggle();
    });
  });

 $(document).ready(function(){
    $("#calculate").click(function(){
        if($('div').hasClass('chartdiv2')){
          $('.chartdiv2').hide();
        }
          $('#chartdiv3').toggle();
    });
  });

