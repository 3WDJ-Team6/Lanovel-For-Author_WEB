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

//텍스트 셀렉팅 팝업 도구//
function popTool(ResultId, PopbndId) {

    rsbobj = document.getElementById(ResultId); //결과레이어 객체
    popbtnobj = document.getElementById(PopbndId); //버튼레이어 객체

    if (typeof (rsbobj.addEventListener) != "undefined") {
        rsbobj.addEventListener("mouseup", this.popopen, false);
        rsbobj.addEventListener("mousedown", this.hiddenPopbtn, false);
    } else { //IE
        rsbobj.attachEvent("onmouseup", this.popopen);
        rsbobj.attachEvent("onmousedown", this.hiddenPopbtn);
    }
}
popTool.prototype = {
    //도구버튼 숨기기
    hiddenPopbtn: function () {
        if (popbtnobj != null) {
            popbtnobj.style.display = "none";
        }
    },
    //팝업창 
    popopen: function (e) {
        var event = window.event || e;
        var kwd = getSelectText();

        //[1] text길이 체크
        if (kwd.length <= 0)
            return;

        //팝업창 보이기
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

//리소스 드래그앤드랍
function allowDrop(ev) {
    ev.preventDefault();
}
function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.src);
}
var drop_id = 0;
function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    console.log(document.getElementById(data));
    var image = "<span id='drop_id"+drop_id+"' class='effect'><img src=" + "'" + data + "'" + " class='resize'></span><br>";
    console.log(data);
    console.log(ev.target);
    $(document).ready(function(){
        $('.effect').selectable();
        $(ev.target).append(image);
        drop_id++;
    });
}
//리소스 드래그앤드랍//

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
    // $('#justifyRight').after('<span class="btn tool-btn" id="resource">리소스</span>');

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

    //템플릿관리
    $('#template').click(function () {
        if ($('div').hasClass('ep')) {
            $('.ep').hide();
        }
        $('.tem').toggle();
    });
    //템플릿 효과
    $('#shadow').click(function () {
        $('ui-selected').toggleClass('shadow');
    });
    $('#inshadow').click(function () {
        $('.ui-selected').toggleClass('inshadow');
    });
    $('#spin').click(function () {
        $('.ui-selected').toggleClass('spin');
    });
    $('#radius').click(function () {
        $('.ui-selected').toggleClass('radius');
    });
    $('#oval').click(function () {
        $('.ui-selected').toggleClass('oval');
    });
    // $('#circle').click(function () {
    //     $('.resize').toggleClass('circle');
    // });
    var cir_flag = false;
    $('#circle').click(function () {
        if(cir_flag === false){
            cir_flag = true;
            $('.ui-selected').css({
                'position': 'relative',
                'display': 'inline-block',
                'border-radius': '50%',
                'width': '250px',
                'height': '250px'
            });
        }
        // else if(cir_flag === true){
        //     $('.ui-selected').css({
        //         'position': 'relative',
        //         'width': '400px',
        //         'height': 'auto'
        //     });
        // }
    });
    
    $('#overlap').click(function () {
        $('.ui-selected').toggleClass('overlap');
    });
    $('#blur').click(function () {
        $('.ui-selected').toggleClass('blur');
    });
    $('#album').click(function () {
        $('.ui-selected').toggleClass('album');
    });
    //템플릿//

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //리소스
    // var flag = true;
    // $("#resource").click(function () {
    //     if (flag === true) {
    //         flag = false;
    //         $.ajax({
    //             type: 'POST',
    //             url: "/res",
    //             dataType:"JSON",
    //             error: function(e){
    //                 console.log(e);
    //                 throw new Error('실-패');
    //         },
    //             success: function (data) {
    //                 console.log(data);
    //                 $('.resource-area').html(data);
    //                 $('.resource-area').load(data);
                    
    //                 // $('.resource-area').innerHTML(data);
    //             }
    //         });
    //     } else if (flag === false) {
    //         flag = true;
    //         $('.resource-area').empty();
    //     }
    // });
    // var flag = true;
    // $("#resource").click(function () {
    //     if (flag === true) {
    //         flag = false;
    //         $.ajax({
    //             type: 'GET',
    //             url: "/res",
    //             // dataType:"JSON",
    //             error: function(e){
    //                 console.log(e);
    //                 throw new Error('실-패');
    //         },
    //             success: function (data) {
    //                 console.log(data);
    //                 $('.resource-area').append(data);
    //             }
    //         });
    //     } else if (flag === false) {
    //         flag = true;
    //         $('.resource-area').empty();
    //     }
    // });

        $.ajax({
            type : 'GET',
            url : "/res",
            error: function(e){
                console.log(e);
                throw new Error('실-패');
            },
            success : function(data){
                $('.resource-area').append(data);
            }
        });

        var resres = "";
        $(document).on("click", ".openView", function(){
            resres = $(this).attr('url');
            // alert(resres);
            $.ajax({
                type: 'GET',
                url: 'https://s3.ap-northeast-2.amazonaws.com/lanovebucket/index.html',
                data: resres,
                error: function(data){
                    console.log(22222222);
                    console.log(data);
                    throw new Error('실-패');
                },
                success : function(data){
                    console.log(111111111);
                    console.log(data);
                    $('.resource-area').html(data);
                }
            });
        });
 
    
        // $('.openView').click(function(e){
        //     $.ajax({
        //         type: 'GET',
        //         url: '/res',
        //         data: e.url,
        //         error: function(data){
        //             console.log(data);
        //             throw new Error('실-패');
        //         },
        //         success : function(data){
        //             console.log(data);
        //             $('.resource-area').html(data);
        //         }
        //     });
        //     return false;
        // });

    

    //리소스 땡겼을 때 p 태그안에 thum클래스를 resize로 수정하고 리사이징가능하게
    // $('.textarea').hover(function () {
    //     $('p > .thum').addClass('resize').resizable().selectable();
    // });

    //텍스트에리어로 마우스 올라가면 p태그안의 thum클래스를 resize로 바꾸고 div로 감싼다
    // $('.textarea').hover(function () {
    //     $('.textarea .obj_thumb').attr('class', 'resize').wrap('<div class="effect" id="selectable" style="display:inline-block;width:auto;height:auto;"></div>');
    //     $('#selectable').selectable().append('<br/>');
    // });
    // $(window).load(function(){
    //     $('.textarea .obj_thumb').attr('class', 'resize').wrap('<div class="effect" id="selectable" style="display:inline-block;width:auto;height:auto;"></div>');
    //     $('#selectable').selectable().after('<br />');
    // });
    // $('.resize').on('click', 'addproduct', function(){
    //     $('.effect').addClass('selected');
    // });
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
        $('.ui-selected').width($('.ui-selected').width() + 50);
        $('.ui-selected').height($('.ui-selected').height('auto'));
    });
    $('#small').click(function () {
        $('#e-size').width($('#e-size').width() - 50);
        $('#e-size').height($('#e-size').height('auto'));
        $('.ui-selected').width($('.ui-selected').width() - 50);
        $('.ui-selected').height($('.ui-selected').height('auto'));
    });
    $('#origin').click(function () {
        $('#e-size').width($('#e-size').width('400px'));
        $('#e-size').height($('#e-size').height('auto'));
        $('.ui-selected').width($('.ui-selected').width('400px'));
        $('.ui-selected').height($('.ui-selected').height('auto'));
    });
    //템플릿 크게, 작게, 원래사이즈//
});
