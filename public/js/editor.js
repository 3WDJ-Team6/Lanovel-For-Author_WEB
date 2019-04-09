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
    if (typeof cmd.desc == "string") {
        val = prompt(cmd.desc, cmd.val);
    } else if (typeof cmd.val !== "undefined") {
        val = cmd.val;
    } else {
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

//템플릿데이터
function dragStart(data, target) {
    target.dataTransfer.setData("Text", data);
}

function drop(target) {
    target.dataTransfer;
}
//템플릿데이터//

//셀렉트
function SelectSelectableElement (selectableContainer, elementsToSelect)
{
    // add unselecting class to all elements in the styleboard canvas except the ones to select
    $(".ui-selected", selectableContainer).not(elementsToSelect).removeClass("ui-selected").addClass("ui-unselecting");

    // add ui-selecting class to the elements to select
    $(elementsToSelect).not(".ui-selected").addClass("ui-selecting");

    // trigger the mouse stop event (this will select all .ui-selecting elements, and deselect all .ui-unselecting elements)
    selectableContainer.data("selectable")._mouseStop(null);
}
//셀렉트//

$(document).ready(function () {
    if($('div').hasClass('.effect')){
        $('#e-size').selectable();
    }
    //에피소드, 템플릿출력
    $('#italic').before('<span class="btn tool-btn" id="episode">에피소드 관리</span> <span class="btn tool-btn" id="template">템플릿</span>');

    //자동들여쓰기, 리소스 출력
    $('#underline').after('<span class="btn tool-btn" id="auto-indent">자동들여쓰기</span> <span class="btn tool-btn" id="resource">리소스</span>');

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
    $('#episode').click(function () {
        if ($('div').hasClass('tem')) {
            $('.tem').hide();
        }
        $('.ep').toggle();
    });

    $('#ep-add').click(function () {
        window.open('ep_add', 'window', 'width=400, height=400');
    });
    //에피소드관리//

    //템플릿
    $('#template').click(function () {
        if ($('div').hasClass('ep')) {
            $('.ep').hide();
        }
        $('.tem').toggle();
    });

    $('#shadow').click(function () {
        $('.effect').toggleClass('shadow');
    });
    $('#inshadow').click(function () {
        $('.effect').toggleClass('inshadow');
    });
    $('#spin').click(function () {
        $('.effect').toggleClass('spin');
    });
    $('#radius').click(function () {
        $('.resize').toggleClass('radius');
    });
    $('#oval').click(function () {
        $('.resize').toggleClass('oval');
    });
    $('#circle').click(function () {
        $('.resize').toggleClass('circle');
    });
    $('#overlap').click(function () {
        $('.effect').toggleClass('overlap');
    });
    $('#blur').click(function () {
        $('.effect').toggleClass('blur');
    });
    $('#album').click(function () {
        $('.effect').toggleClass('album');
    });
    //템플릿//

    //리소스
    var flag = true;
    $("#resource").click(function () {
        if ($('div').hasClass('ep')) {
            $('.ep').hide();
        }
        $('.tem').toggle();
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

    //리소스 땡겼을 때 p 태그안에 thum클래스를 resize로 수정하고 리사이징가능하게
    // $('.textarea').hover(function () {
    //     $('p > .thum').addClass('resize').resizable().selectable();
    // });

    //텍스트에리어로 마우스 올라가면 p태그안의 thum클래스를 resize로 바꾸고 div로 감싼다
    $('.textarea').hover(function () {
        $('p .thum').attr('class','resize').wrap('<div class="effect" id="selectable" style="display:inline-block;width:auto;height:auto;"></div>');
        // $('#selectable').selectable();
    });
    // if($('p > img').hasClass('thum')){
    //     console.log(11);
    //     $('.thum').attr('class','resize').wrap('<div class="effect" id="selectable" style="display:inline-block;width:500px;height:auto;"></div>');
    //     $('#selectable').selectable();
    // }
    // $('.resize').selectable({
    //     selected: function(event, ui){
    //         if($(ui.selected).hasClass('.resize')){
    //             $('.resize').addClass('selected');
    //         }
    //     }
    // });
    //리소스//

    //미리보기+루비
    $('#pre-btn').click(function () {
        $('.textarea').each(function () {
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
    //미리보기+루비//

    //포커스
    // $(function(){
    //     var text1 = $('.textarea');
    //     text1.focus(function(){
    //     text1.append('포커스');
    //     });
    //     text1.blur(function(){
    //     text1.replace(/포커스/gi, 'ㅇ');
    //     });
    // });
    //포커스//

    //a태그 드래그 금지
    $('body').hover(function () {
        $("a").attr("draggable", "false");
    });
    //a태그 드래그 금지//

    $('#large').click(function(){
        $('#e-size').width($('#e-size').width()+50);
        $('#e-size').height($('#e-size').height('auto'));
        $('.resize').width($('.resize').width()+50);
        $('.resize').height($('.resize').height('auto'));
    });
    $('#small').click(function(){
        $('#e-size').width($('#e-size').width()-50);
        $('#e-size').height($('#e-size').height('auto'));
        $('.resize').width($('.resize').width()-50);
        $('.resize').height($('.resize').height('auto'));
    });
    $('#origin').click(function(){
        $('#e-size').width($('#e-size').width('400px'));
        $('#e-size').height($('#e-size').height('auto'));
        $('.resize').width($('.resize').width('400px'));
        $('.resize').height($('.resize').height('auto'));
    });
});