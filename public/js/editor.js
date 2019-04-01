

//버튼생성
var commands = [{
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

//텍스트 셀렉팅 팝업 도구//
function popTool(ResultId, PopbndId) {

    rsbobj = document.getElementById(ResultId); //결과레이어 객체
    popbtnobj = document.getElementById(PopbndId); //버튼레이어 객체

    if (typeof (rsbobj.addEventListener) != "undefined") { //FF
        rsbobj.addEventListener("mouseup", this.popopen, false);
        rsbobj.addEventListener("mousedown", this.hiddenPopbtn, false);
    } else { //IE
        rsbobj.attachEvent("onmouseup", this.popopen);
        rsbobj.attachEvent("onmousedown", this.hiddenPopbtn);
    }
}
popTool.prototype = {
    //검색버튼 숨기기
    hiddenPopbtn: function () {
        if (popbtnobj != null) {
            popbtnobj.style.display = "none";
        }
    },
    //팜업창 
    popopen: function (e) {
        var event = window.event || e;
        var kwd = getSelectText();

        //[1] text길이 체크
        if (kwd.length <= 0)
            return;
        // else if (kwd.length >= limit)
        // {
        // 	alert("드래그 검색은 " + limit + "글자만 지원합니다");
        // 	return;
        // }

        //팜업창 보이기

        popbtnobj.style.display = "block";

        //[3 ] 마우스 x,y좌표 구하기
        var mouseX = (event.clientX);
        var mouseY = (event.clientY);
        mouseX += getScrollLeft();
        mouseY += getScrollTop();
        popbtnobj.style.top = mouseY + "px";
        popbtnobj.style.left = mouseX + "px";
    }

}
//마우스로 긁은 TEXT
function getSelectText() {
    var d = "";
    if (window.getSelection) {
        d = window.getSelection();
    } else if (document.getSelection) {
        d = document.getSelection();
    } else if (document.selection) {
        d = document.selection.createRange().text;
    }

    d = String(d);
    d.replace(/^\s+|\s+$/g, ''); //trim
    return d;
}

//스크롤된 Left 구하기
function getScrollLeft() {
    var dd = document.documentElement;
    var bd = document.body;

    var dd_top = 0;
    var bd_top = 0;

    if (typeof (dd) == "object")
        dd_top = dd.scrollLeft;
    if (typeof (bd) == "object")
        bd_top = bd.scrollLeft;

    if (dd_top > bd_top)
        return dd_top;
    else
        return bd_top;
}
//스크롤된 Top 구하기
function getScrollTop() {
    var dd = document.documentElement;
    var bd = document.body;

    var dd_top = 0;
    var bd_top = 0;

    if (typeof (dd) == "object")
        dd_top = dd.scrollTop;
    if (typeof (bd) == "object")
        bd_top = bd.scrollTop;

    if (dd_top > bd_top)
        return dd_top;
    else
        return bd_top;
}
//텍스트 셀렉팅 도구//
$(document).ready(function () {

    //포커스 미완
    $('.select').attr("tabindex", -1);
    $('.area').mousemove(function () {
        $('.select').focus(function () {
            $(this).css("border", "2px solid yellow").addClass('selected');
        });
        $('.select.selected').blur(function () {
            $(this).css("border", "0").removeClass('selected');
        });
    });
    //포커스//

    //에피소드, 템플릿출력
    $('#createLink').before('<span class="btn tool-btn" id="episode">에피소드 관리</span> <span class="btn tool-btn" id="template">템플릿</span>');

    //리소스 출력
    $('#justifyRight').after('<span class="btn tool-btn" id="resource">리소스</span>');

    //에피소드관리 
    $('#episode').click(function () {
        if ($('div').hasClass('tem')) {
            $('.tem').hide();
        }
        $('.ep').toggle();
    });
    //에피소드추가
    $('#ep-add').click(function () {
        window.open('/ep_add', 'window', 'width=400, height=400');
    });
    //에피소드관리//

    //템플릿
    $('#template').click(function () {
        if ($('div').hasClass('ep')) {
            $('.ep').hide();
        }
        $('.tem').toggle();
    });
    //템플릿 효과
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

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //리소스
    var flag = true;
    $("#resource").click(function () {
        if (flag === true) {
            flag = false;
            $.ajax({
                type: 'POST',
                url: "/res",
                dataType:"JSON",
                error: function(e){
                    console.log(e);
                    throw new Error('실-패');
            },
                success: function (data) {
                    console.log(data);
                    $('.resource-area').html(data);
                    $('.resource-area').load(data);
                    
                    // $('.resource-area').innerHTML(data);
                }
            });
        } else if (flag === false) {
            flag = true;
            $('.resource-area').empty();
        }
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
        $('.textarea .obj_thumb').attr('class', 'resize').wrap('<div class="effect" id="selectable" style="display:inline-block;width:auto;height:auto;"></div>');
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

    //템플릿 크게, 작게, 원래사이즈
    $('#large').click(function () {
        $('#e-size').width($('#e-size').width() + 50);
        $('#e-size').height($('#e-size').height('auto'));
        $('.resize').width($('.resize').width() + 50);
        $('.resize').height($('.resize').height('auto'));
    });
    $('#small').click(function () {
        $('#e-size').width($('#e-size').width() - 50);
        $('#e-size').height($('#e-size').height('auto'));
        $('.resize').width($('.resize').width() - 50);
        $('.resize').height($('.resize').height('auto'));
    });
    $('#origin').click(function () {
        $('#e-size').width($('#e-size').width('400px'));
        $('#e-size').height($('#e-size').height('auto'));
        $('.resize').width($('.resize').width('400px'));
        $('.resize').height($('.resize').height('auto'));
    });
    //템플릿 크게, 작게, 원래사이즈
    $('#send').click(function() {
        var cont = $('#popup_result').html(); 
        $('#content').val(cont);
        $('#form').submit();
        console.log(cont);
       });
});
