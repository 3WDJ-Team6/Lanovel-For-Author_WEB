$(function(){
    $.ajax({
        url:"/js/cal.js",
        dataType:"JSON",
        sucess:function(data){
            console.log(data);
            $.each(data, function(){
                $('#tabList').append("<tr><td>"+this["num"]+"</td><td>"+this["buysu"]+"</td></tr>");
            });
        },
        error:function(data){
            alert(console.log(data));
        }
    });
});