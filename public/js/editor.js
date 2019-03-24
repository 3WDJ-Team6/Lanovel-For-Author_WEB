//버튼생성
var commands = [{
    "cmd": "italic",
    "name": "기울이기"
}, {
    "cmd": "bold",
    "name": "굵게"
}, {
    "cmd": "createLink",
    "val": "https://youtu.be/BXcUred6iXc?t=14",
	"name": "링크추가",
	"desc": "링크를 추가하거나 텍스트를 드래그해서 링크를 달 수 있습니다."
}, {
    "cmd": "unlink",
    "name": "링크지우기"
}, {
    "cmd": "fontSize",
    "val": "3",
	"name": "글자크기",
	"desc": "1(가장 작음)~7(가장 큼) 중 하나를 선택해 크기를 조절할 수 있습니다."
}, {
    "cmd": "indent",
    "name": "우로밀기"
}, {
    "cmd": "outdent",
    "name": "좌로밀기"
}, {
    "cmd": "insertHorizontalRule",
    "name": "가로줄"
}, {
    "cmd": "justifyCenter",
    "name": "중앙정렬"
}, {
    "cmd": "justifyLeft",
    "name": "좌측정렬"
}, {
    "cmd": "justifyRight",
    "name": "우측정렬"
}, {
    "cmd": "strikeThrough",
    "name": "중앙선긋기"
}, {
    "cmd": "underline",
    "name": "밑줄긋기"
}];

var commandRelation = {};

function doCommand(cmdKey) {
	var val;
    var cmd = commandRelation[cmdKey];
	if(typeof cmd.desc == "string"){
		val = prompt(cmd.desc, cmd.val);
	}else if(typeof cmd.val !== "undefined"){
		val = cmd.val;
	}else{
		val = '';
	}
    document.execCommand(cmd.cmd, false, (val || ""));
}

function init() {
    var html = '',
        template = '<span class="btn tool-btn" id="%cmd%" onclick="doCommand(\'%cmd%\')">%nam%</span>';
    commands.map(function (command, i) {
        commandRelation[command.cmd] = command;
        var temp = template;
        temp = temp.replace(/%cmd%/gi, command.cmd);
        temp = temp.replace(/%nam%/gi, command.name);
        html += temp;
    });
    document.querySelector(".tool-btns").innerHTML = html;
}

init();

//에피소드 템플릿출력
$(document).ready(function(){
	$('#italic').before('<span class="btn tool-btn" id="episode">에피소드 관리</span> <span class="btn tool-btn" id="template">템플릿</span>');
});

//자동들여쓰기 리소스 출력
$(document).ready(function(){
	$('#underline').after('<span class="btn tool-btn" id="auto-indent">자동들여쓰기</span> <span class="btn tool-btn" id="resource">리소스</span>');
});
//버튼생성//

//엔터마다 p 아이디 늘리기
// $(document).ready(function(){
// 	$(".textarea").keypress(function(){
// 		$("p").attr('id' , String(parseInt('id')+'1'));
// 	});
// });
//엔터마다 p 아이디 늘리기//

//자동들여쓰기
// $(document).ready(function(){
// 	$('#indent').one('click',function(){
// 		$('.textarea').keydown(function(key){
// 			if(key.keyCode == 13){
// 				$('p').css('text-indent', '2em');
// 			}
// 		});
// 	});.
// });
//자동들여쓰기//

//에피소드관리 
$(document).ready(function () {
    $('#episode').click(function() {
        if($('div').hasClass('tem')){
            $('.tem').hide();
        }
		$('.ep').toggle();
    });
});
$(document).ready(function () {
    $('#ep-add').click(function(){
        window.open('ep_add', 'window', 'width=400, height=400');
    });
});
//에피소드관리//

//템플릿
$(document).ready(function () {
    $('#template').click(function() {
        if($('div').hasClass('ep')){
            $('.ep').hide();
        }
		$('.tem').toggle();
    });
});

function dragStart(target, data) {
    data.dataTransfer.setData("Text", target.title);
}


function drop(target, data) {
    var title = data.dataTransfer.getData("Text");
    target.append(document.getData(title));	
}
//템플릿//

//리소스
var flag = true;
$(document).ready(function(){
    $("#resource").click(function(){
        if(flag === true){
            flag = false;
            $.ajax({
                type : 'GET',
                url : "res",
                success : function(data){
                    $('.resource-area').append(data);
                }
            });
        }else if(flag === false){
            flag = true;
            $('.resource-area').empty();
        }
    });
});
// $(document).ready(function(){
//     $.ajax({
//         type : 'GET',
//         url : "res",
//         success : function(data){
//             $('.resource_area').append(data);
//         }
//     });
// });
    //리소스 땡겼을 때 p 태그안에 thum클래스를 thum-resize로 수정하고 리사이징가능하게
$(document).ready(function(){
    $('.textarea').hover(function(){
        $('p > .thum').attr('class' , 'thum-resize').resizable();
    });
});
//리소스//
//루비
$(function(){
    $('#pre-btn').click(function(){
        $('.textarea').each(function(){
            var text = $('.textarea').html();
            console.log(text);
            $('#result').html(text);
            $('#result').html(
                $('#result').html()
                    .replace(/[\|｜](.+?)《(.+?)》/g, '<ruby>$1<rt>$2</rt></ruby>')
                    .replace(/[\|｜](.+?)（(.+?)）/g, '<ruby>$1<rt>$2</rt></ruby>')
                    .replace(/[\|｜](.+?)\((.+?)\)/g, '<ruby>$1<rt>$2</rt></ruby>')
                    .replace(/([一-龠]+)《(.+?)》/g, '<ruby>$1<rt>$2</rt></ruby>')
                    .replace(/([一-龠]+)（([ぁ-んァ-ヶ]+?)）/g, '<ruby>$1<rt>$2</rt></ruby>')
                    .replace(/([一-龠]+)\(([ぁ-んァ-ヶ]+?)\)/g, '<ruby>$1<rt>$2</rt></ruby>')
                    .replace(/[\|｜]《(.+?)》/g, '《$1》')
                    .replace(/[\|｜]（(.+?)）/g, '（$1）')
                    .replace(/[\|｜]\((.+?)\)/g, '($1)')
            );
        });
    });
});
//루비//

//미리보기
$(document).ready(function(){
    $('#preview').click(function(){
        // $('#preview-modal').css('display', 'inline-block');
    });
});
//미리보기//