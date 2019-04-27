//버튼생성
var commands = [
    {
        cmd: "createLink",
        val: "https://youtu.be/BXcUred6iXc?t=14",
        name: "링크추가",
        desc: "링크를 추가하거나 텍스트를 드래그해서 링크를 달 수 있습니다."
    },
    {
        cmd: "unlink",
        name: "링크지우기"
    },
    {
        cmd: "fontSize",
        val: "3",
        name: "글자크기",
        desc:
            "1(가장 작음)~7(가장 큼) 중 하나를 선택해 크기를 조절할 수 있습니다."
    },
    {
        cmd: "indent",
        name: "우로밀기"
    },
    {
        cmd: "outdent",
        name: "좌로밀기"
    },
    {
        cmd: "insertHorizontalRule",
        name: "가로줄"
    },
    {
        cmd: "justifyCenter",
        name: "중앙정렬"
    },
    {
        cmd: "justifyLeft",
        name: "좌측정렬"
    },
    {
        cmd: "justifyRight",
        name: "우측정렬"
    }
];

var commandRelation = {};

function doCommand(cmdKey) {
    var val;
    var cmd = commandRelation[cmdKey];
    if (typeof cmd.desc == "string") {
        val = prompt(cmd.desc, cmd.val);
    } else if (typeof cmd.val !== "undefined") {
        val = cmd.val;
    } else {
        val = "";
    }
    document.execCommand(cmd.cmd, false, val || "");
}

function init() {
    var html = "",
        template =
            '<span class="btn tool-btn" id="%cmd%" onclick="doCommand(\'%cmd%\')">%nam%</span>';
    commands.map(function(command, i) {
        commandRelation[command.cmd] = command;
        var temp = template;
        temp = temp.replace(/%cmd%/gi, command.cmd);
        temp = temp.replace(/%nam%/gi, command.name);
        html += temp;
    });
    document.querySelector(".tool-btns").innerHTML = html;
}

init();

function popupInEditor(num) {
    // alert(num);
    var url = "/content_create_in_editor/" + num;
    var option = "width=600, height=300, top=100";
    window.open(url, "", option);
}

function popupEdit(num) {
    var url = "/content_edit_in_editor/" + num;
    var option = "width=600, height=300, top=100";
    window.open(url, "", option);
}

//텍스트 셀렉팅 팝업 도구//

function popTool(ResultId, PopbndId) {
    rsbobj = document.getElementById(ResultId); //결과레이어 객체
    popbtnobj = document.getElementById(PopbndId); //버튼레이어 객체

    if (typeof rsbobj.addEventListener != "undefined") {
        rsbobj.addEventListener("mouseup", this.popopen, false);
        rsbobj.addEventListener("mousedown", this.hiddenPopbtn, false);
    } else {
        //IE
        rsbobj.attachEvent("onmouseup", this.popopen);
        rsbobj.attachEvent("onmousedown", this.hiddenPopbtn);
    }
}

popTool.prototype = {
    //도구버튼 숨기기
    hiddenPopbtn: function() {
        if (popbtnobj != null) {
            popbtnobj.style.display = "none";
        }
    },
    //팝업창
    popopen: function(e) {
        var event = window.event || e;

        var kwd = getSelectText();
        if (kwd.length <= 0) return;

        //팝업창 보이기
        popbtnobj.style.display = "block";

        //마우스 x,y좌표 구하기
        var mouseX = event.clientX;
        var mouseY = event.clientY;
        mouseX += getScrollLeft();
        mouseY += getScrollTop();
        popbtnobj.style.top = mouseY + "px";
        popbtnobj.style.left = mouseX + "px";
    }
};
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
    d.replace(/^\s+|\s+$/g, ""); //trim

    return d;
}

//스크롤된 Left 구하기
function getScrollLeft() {
    var dd = document.documentElement;
    var bd = document.body;

    var dd_top = 0;
    var bd_top = 0;

    if (typeof dd == "object") dd_top = dd.scrollLeft;
    if (typeof bd == "object") bd_top = bd.scrollLeft;

    if (dd_top > bd_top) return dd_top;
    else return bd_top;
}
//스크롤된 Top 구하기
function getScrollTop() {
    var dd = document.documentElement;
    var bd = document.body;

    var dd_top = 0;
    var bd_top = 0;

    if (typeof dd == "object") dd_top = dd.scrollTop;
    if (typeof bd == "object") bd_top = bd.scrollTop;

    if (dd_top > bd_top) return dd_top;
    else return bd_top;
}
//텍스트 셀렉팅 도구//

//리소스 드래그앤드랍
// function allowDrop(ev) {
//     ev.preventDefault();
// }

// function drag(ev) {
//     var aaa = ev.dataTransfer.setData("text", ev.target.title);
//     console.log("aaa" + aaa);
// }

// var drop_id = 0;

// function drop(ev) {
//     ev.preventDefault();
//     var data = ev.dataTransfer.getData("text");
//     var image =
//         "<span id='drop_id" +
//         drop_id +
//         "' class='effect'><img src=" +
//         "'" +
//         data +
//         "'" +
//         " class='resize'></span><br>";
//     $(document).ready(function () {
//         $(ev.target).append(image);
//         drop_id++;
//     });
// }
//리소스 드래그앤드랍//

//메모팝업
function memoPopup(e, idNum) {
    var top = e.clientY + 10;
    var left = e.clientX + 10;
    console.log("memoPopup실행되고있나");
    console.log(idNum);

    $("#memoPopupId" + idNum)
        .toggle()
        .css({
            top: top,
            left: left
        });
}

var memoViewId = 1;
var memoPopupId = 1;

function memoBalloon(e) {
    var span = document.createElement("span");
    var top = e.clientY - 53;
    var back = ["#ffc", "#cfc", "#ccf"];
    var rand = back[Math.floor(Math.random() * back.length)];

    console.log(rand);
    if (window.getSelection) {
        var txt = window.getSelection();
        if (txt.rangeCount) {
            var range = txt.getRangeAt(0).cloneRange();
            range.surroundContents(span);
            txt.removeAllRanges();
            txt.addRange(range);
            if (
                !$(".textarea span:contains(" + txt + ")").hasClass(
                    "memoballoon"
                )
            ) {
                $(".textarea span:contains(" + txt + ")").addClass(
                    "memoballoon"
                );
                $(".textarea span:contains(" + txt + ")").prepend(
                    "<div id=" +
                        "'memoViewId" +
                        memoViewId +
                        "'" +
                        "class='balloon' style='top:" +
                        top +
                        "px;' onclick='memoPopup(event," +
                        memoViewId +
                        ");'></div>" +
                        "<div id=" +
                        "'memoPopupId" +
                        memoPopupId +
                        "'" +
                        "class='memoPopup' contenteditable='false' style='background-color:" +
                        rand +
                        "'>" +
                        "<form method='POST' action='/store_memo/" +
                        num_of_work +
                        "/" +
                        memoViewId +
                        "'>" +
                        "<textarea name='content_of_memo' class='underline' autocorrect='false'>" +
                        "</textarea>" +
                        "<span>유저이름</span>" +
                        "<button type='submit' class='memoSave'>" +
                        "<span class='memoSaveSpan'><span>" +
                        "</button>" +
                        "</form>" +
                        "</div>"
                );
                $(".textarea span:contains(" + txt + ")").css(
                    "background-color",
                    "yellow"
                );
                memoViewId++;
                memoPopupId++;
            } else if (
                $(".textarea span:contains(" + txt + ")").hasClass(
                    "memoballoon"
                )
            ) {
                console.log("실행되고잇니hasClass");
            }
        }
    }
}
//메모팝업//

//에피소드 추가
function addEpisode(sub, num) {
    console.log("실행됬냐" + sub);
    $(".ep-list").append(
        "<h4><a href=/editor/tool/editor/" + num + ">- " + sub + "</a></h4>"
    );
}
//에피소드 추가//

//에피소드 수정
function editEpisode(chgsub, orisub) {
    console.log("바뀐제목 : " + chgsub + " 원래제목 : " + orisub);
    $(".ep-title").text(chgsub);
    $(".ep-list h4 a").each(function() {
        var text = $(this).text();
        console.log("text : " + text);
        $(this).text(text.replace(orisub, chgsub));
    });
}
//에피소드 수정//

$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    //포커스 미완
    $(".select").attr("tabindex", -1);
    $(".area").mousemove(function() {
        $(".select").focus(function() {
            $(this)
                .css("border", "2px solid yellow")
                .addClass("selected");
        });
        $(".select.selected").blur(function() {
            $(this)
                .css("border", "0")
                .removeClass("selected");
        });
    });
    //포커스//

    //에피소드, 템플릿출력
    // $('#createLink').before('<span class="btn tool-btn" id="episode">에피소드 관리</span> <span class="btn tool-btn" id="template">템플릿</span>');

    //리소스 출력
    // $('#justifyRight').after('<span class="btn tool-btn" id="resource">리소스</span>');
    $("#justifyRight").after(
        "<span class='btn tool-btn' id='memo'>메모</span>"
    );

    //에피소드관리
    $("#ep").click(function() {
        if ($(".ep-tem").prop("id") == "ep") {
            $(".tem").hide();
        }
        // if ($('div').hasClass('tem')) {
        //     $('#tem').hide();
        // }
        $(".ep").show();
    });
    //에피소드관리//

    //템플릿관리
    $("#tem").click(function() {
        if ($("div").hasClass("ep")) {
            $(".ep").hide();
        }
        $(".tem").show();
    });
    //템플릿 효과
    $("#shadow").click(function() {
        $("ui-selected").toggleClass("shadow");
    });
    $("#inshadow").click(function() {
        $(".ui-selected").toggleClass("inshadow");
    });
    $("#spin").click(function() {
        $(".ui-selected").toggleClass("spin");
    });
    $("#radius").click(function() {
        $(".ui-selected").toggleClass("radius");
    });
    $("#oval").click(function() {
        $(".ui-selected").toggleClass("oval");
    });
    // $('#circle').click(function () {
    //     $('.resize').toggleClass('circle');
    // });
    var cir_flag = false;
    $("#circle").click(function() {
        if (cir_flag === false) {
            cir_flag = true;
            $(".ui-selected").css({
                position: "relative",
                display: "inline-block",
                "border-radius": "50%",
                width: "250px",
                height: "250px"
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

    $("#overlap").click(function() {
        $(".ui-selected").toggleClass("overlap");
    });
    $("#blur").click(function() {
        $(".ui-selected").toggleClass("blur");
    });
    $("#album").click(function() {
        $(".ui-selected").toggleClass("album");
    });
    //템플릿//

    //리소스파일 리스팅
    let folder = "";
    var chng_text = "";
    var folder_name = "";

    function getResource() {
        $.ajax({
            type: "GET",
            url: "/getDir/" + num_of_work, //private, public, 나중에 책의 num값도 넘겨줘야함
            dataType: "json",
            error: function(e) {
                console.log(e);
                throw new Error("실-패");
            },
            success: function(data) {
                console.log(data);
                for (var i = 0; i < 2; i++) {
                    folder_name = Object.keys(data)[i].replace("_FOLDER", "");
                    $("#resource-feild").append(
                        "<span id='obj_" +
                            i +
                            "' class='obj'><span class='obj_folder' style='background-image: url(\"/image/folder_icon.png\");background-size: 120px 120px;'></span><span class='obj_name'>" +
                            folder_name +
                            "</span></span"
                    );
                }
            }
        });
    }
    $(document).on("click", ".obj", function() {
        if (this.id == "obj_0") {
            folder = "private";
        } else if (this.id == "obj_1") {
            folder = "public";
        }
        $.ajax({
            type: "GET",
            url: "/getDir/" + num_of_work + "/" + folder,
            dataType: "json",
            error: function(data) {
                console.log(22222222);
                console.log(data);
                throw new Error("실-패");
            },
            success: function(data) {
                console.log(111111111);
                console.log(343434434);
                console.log(data);
                data.reverse();
                console.log("folder : " + folder);
                $("#resource-feild").html("");
                $.each(data, function(index, item) {
                    // console.log("item.name : " + item.name);
                    // console.log("item.src : " + item.src);
                    // console.log("index : " + index);
                    chng_text = item.name.substr(0, 9) + "...";
                    $("#resource-feild").append(
                        "<span id='obj_" +
                            index +
                            "' class='obj_file'><img src='" +
                            item.src +
                            "' class='obj_thum' /><span class='obj_name' title='" +
                            item.name +
                            "'>" +
                            chng_text +
                            "</span></span>"
                    );
                });
                $("#resource-feild").prepend(
                    "<div class='back'>" +
                        "<svg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' version='1.1' id='Layer_1' x='0px' y='0px' viewBox='0 0 512.001 512.001' style='enable-background:new 0 0 512.001 512.001;' xml:space='preserve' width='32px' height='32px' class=''><g><g>" +
                        "<g>" +
                        "<path d='M384.834,180.699c-0.698,0-348.733,0-348.733,0l73.326-82.187c4.755-5.33,4.289-13.505-1.041-18.26    c-5.328-4.754-13.505-4.29-18.26,1.041l-82.582,92.56c-10.059,11.278-10.058,28.282,0.001,39.557l82.582,92.561    c2.556,2.865,6.097,4.323,9.654,4.323c3.064,0,6.139-1.083,8.606-3.282c5.33-4.755,5.795-12.93,1.041-18.26l-73.326-82.188    c0,0,348.034,0,348.733,0c55.858,0,101.3,45.444,101.3,101.3s-45.443,101.3-101.3,101.3h-61.58    c-7.143,0-12.933,5.791-12.933,12.933c0,7.142,5.79,12.933,12.933,12.933h61.58c70.12,0,127.166-57.046,127.166-127.166    C512,237.745,454.954,180.699,384.834,180.699' data-original='#000000' class='active-path'" +
                        "data-old_color='#B7CBFC' fill='#476ACD'/>" +
                        "</g>" +
                        "</div>"
                );
                $(".back").after(
                    "<label for='image' class='upload_label'>+</label><input type='file' name='image' id='image' />"
                );
            }
        });
    });
    $(document).on("click", ".back", function() {
        $("#resource-feild").html("");
        getResource();
    });
    getResource();
    //리소스파일 리스팅//

    //파일추가
    $(document).on("change", 'input[type="file"]', function(event) {
        var appendId = 0;
        var reader = new FileReader();
        var form = $("#file_form")[0];
        var formData = new FormData(form);
        formData.append("image", $("#image")[0].files[0]);
        var file_name = $("#image")[0].files[0].name;
        console.log("file_name : " + file_name);
        var chng_name = file_name.substr(0, 9) + "...";
        console.log(reader);
        console.log(form);
        console.log($("#image")[0].files[0].name);
        console.log($("#image")[0].files[0]);

        $.ajax({
            url: "/images",
            processData: false,
            contentType: false,
            data: formData,
            type: "POST",
            success: function() {
                $("span").remove("#file_loading");
            },
            beforeSend: function() {
                $("#image").after("<span id='file_loading'></span>");
            },
            complete: function() {
                // $("#image").after("<span class='obj_file'><img src='" + item.src + "' class='obj_thum' /><span class='obj_name' title='" + item.name + "'>" + chng_text + "</span></span");
                $("#image").after(
                    "<span class='obj_file'><img id='append_" +
                        appendId +
                        "' class='obj_thum' /><span class='obj_name' title='" +
                        file_name +
                        "'>" +
                        chng_name +
                        "</span></span>"
                );
                var output = document.getElementById("append_" + appendId);
                output.src = URL.createObjectURL(event.target.files[0]);
                // $("#append_" + appendId).attr('src', e.target.result);
                appendId++;
            },
            error: function(e) {
                console.log(e + "에러");
            }
        });
    });
    //파일추가//

    //파일 우클릭 & 삭제
    var image_id = "";
    $(document).on("contextmenu", ".obj_file", function() {
        let img = $(this)
            .children(".obj_thum")
            .attr("src");
        $image = $(this)
            .children(".obj_name")
            .attr("title");
        $path = img
            .replace(
                "https://s3.ap-northeast-2.amazonaws.com/lanovebucket/",
                ""
            )
            .replace("" + image, "");
        image_id = this.id;
        console.log("img : " + img);
        console.log("img_path : " + $path);
        console.log("img_name : " + $image);
        console.log(image_id);

        event.preventDefault();
        if ($(".custom-menu").length) {
            $("div.custom-menu").remove();
        }
        $("div.custom-menu").remove();
        $("<div id='file-delete' class='custom-menu'>삭제</div>")
            .appendTo(".resource-area")
            .css({
                top: event.pageY + "px",
                left: event.pageX + "px"
            })
            .bind("click", function() {
                $("div.custom-menu").remove();
            });
        $(document).on("click", "#file-delete", function() {
            console.log("ididid : " + image_id);
            $.ajax({
                method: "delete",
                url: "/images/" + $image,
                type: "POST",
                success: function() {
                    console.log("성공");
                    console.log($image);
                    $("#" + image_id).remove();
                    // $("span span:contains(" + $image + ")").parent().remove();
                },
                error: function(data) {
                    console.log(data);
                    console.log("에러");
                }
            });
        });
        $(document).on("click", "body", function() {
            $("div.custom-menu").remove();
        });
    });
    //파일 우클릭 & 삭제//

    //파일 툴에 넣었을 때
    // $('.textarea').hover(function () {
    //     $('.textarea .obj_thum').attr('class', 'resize').wrap('<div class="effect" style="display:inline-block;width:auto;height:auto;"></div>');
    // });
    //파일 툴에 넣었을 때//

    //미리보기+루비
    $("#pre-btn").click(function() {
        $(".textarea").each(function() {
            var text = $(".textarea").html();
            d;
            $("#result").html(text);
            $("#result").html(
                $("#result")
                    .html()
                    .replace(
                        /[\|｜](.+?)《(.+?)》/g,
                        "<ruby>$1<rt>$2</rt></ruby>"
                    )
                    .replace(
                        /[\|｜](.+?)（(.+?)）/g,
                        "<ruby>$1<rt>$2</rt></ruby>"
                    )
                    .replace(
                        /[\|｜](.+?)\((.+?)\)/g,
                        "<ruby>$1<rt>$2</rt></ruby>"
                    )
                    .replace(
                        /([一-龠]+)《(.+?)》/g,
                        "<ruby>$1<rt>$2</rt></ruby>"
                    )
                    .replace(
                        /([一-龠]+)（([ぁ-んァ-ヶ]+?)）/g,
                        "<ruby>$1<rt>$2</rt></ruby>"
                    )
                    .replace(
                        /([一-龠]+)\(([ぁ-んァ-ヶ]+?)\)/g,
                        "<ruby>$1<rt>$2</rt></ruby>"
                    )
                    .replace(/[\|｜]《(.+?)》/g, "《$1》")
                    .replace(/[\|｜]（(.+?)）/g, "（$1）")
                    .replace(/[\|｜]\((.+?)\)/g, "($1)")
            );
        });
    });
    //미리보기+루비//

    //a태그 드래그 금지
    $("body").hover(function() {
        $("a").attr("draggable", "false");
    });
    //a태그 드래그 금지//

    //템플릿 크게, 작게, 원래사이즈
    $("#large").click(function() {
        $("#e-size").width($("#e-size").width() + 50);
        $("#e-size").height($("#e-size").height("auto"));
        $(".ui-selected > img").width($(".ui-selected > img").width() + 50);
        $(".ui-selected > img").height($(".ui-selected > img").height("auto"));
    });
    $("#small").click(function() {
        $("#e-size").width($("#e-size").width() - 50);
        $("#e-size").height($("#e-size").height("auto"));
        $(".ui-selected > img").width($(".ui-selected > img").width() - 50);
        $(".ui-selected > img").height($(".ui-selected > img").height("auto"));
    });
    $("#origin").click(function() {
        $("#e-size").width($("#e-size").width("400px"));
        $("#e-size").height($("#e-size").height("auto"));
        $(".ui-selected > img").width($(".ui-selected > img").width("400px"));
        $(".ui-selected > img").height($(".ui-selected > img").height("auto"));
    });
    //템플릿 크게, 작게, 원래사이즈//

    //메모
    // var memoViewId = 0;
    // $('#memo').click(function(e){
    //     var divTop = e.clientY + 60;
    //     var divLeft = e.clientX + 60;
    //     console.log(divTop);
    //     console.log(divLeft);
    //     document.ready.append("<div id='memoView"+memoViewId+"' class='memoView' style='top:"+divTop+";left:"+divLeft+";position:absolute;'></div>");
    //     memoViewId++;
    //     $('#memoView')('<textarea style="position:absolute;top:5px;right:5px;"></textarea>');
    //     $('.memoView').css({ "top": divTop ,"left": divLeft , "position": "absolute" }).show();
    // });
    // $('#memo').on('click', function(){
    //     var cursorPos = $('#popup_result').prop('selectionEnd');
    //     var v = $('#popup_result');
    //     console.log(v);
    //     var textBefore = v.substring(0,  cursorPos );
    //     console.log(textBefore);
    //     var textAfter  = v.substring( cursorPos, v.length );
    //     console.log(textAfter);
    //     $('#popup_result').val( textBefore + $(this).val() + textAfter );
    // });
    // $('#memo').click(function(){
    //     $('.textarea').after('aa');
    //     console.log(d+"4");
    // });
    var memoViewId = 0;
    $("#memo").click(function() {
        $(".textarea").prepend(
            "<div id=" +
                "'memoViewId" +
                memoViewId +
                "'" +
                " class='balloon' onclick='memoPopup(event);'></div>"
        );
        memoViewId++;
        $(".balloon").draggable();
        $("#memoPopup").append(
            '<span><form><input type="text" name="edit" style="width:160px;float:right;" readonly required><input style="float:right;" type="submit" name="memosave" value="save"></form></span>'
        );
        $('[name="edit"]').on("click", function() {
            // var prev = $(this).prev('input'),
            var ro = $(this).prop("readonly");
            $(this)
                .prop("readonly", !ro)
                .focus();
            // $(this).val(ro ? 'save' : 'edit');
        });
    });

    // $('.balloon').click(function(e){
    //     var top = e.clientY + 10;
    //     var left = e.clientX + 10;
    //     console.log("살려줘2");
    //     $('#memoPopup').toggle().css({ "top": top ,"left": left });
    // });
    // $(document).on("mouseover", ".balloon", function() {
    //     $(".balloon").draggable();
    // });
    //메모//

    //왼쪽 사이드바
    $("#menuToggle_right").click(function(e) {
        var $parent = $(this).parent("nav");
        $parent.toggleClass("open_right");
        if ($(".open_left").length > 0 && $(".open_right").length == 0) {
            $(".textarea").css("width", "75%");
            $(".resource-area").css("width", "0");
            $(".ep-tem-area").css("width", "20%");
        } else if ($(".open_right").length > 0 && $(".open_left").length > 0) {
            $(".textarea").css("width", "55%");
            $(".resource-area").css("width", "20%");
        } else if ($(".open_right").length > 0) {
            $(".textarea").css("width", "75%");
            $(".resource-area").css("width", "20%");
        } else if ($(".open_right").length == 0) {
            $(".textarea").css("width", "95%");
            $(".resource-area").css("width", "0");
        }
        e.preventDefault();
    });

    //오른쪽사이드바
    $("#menuToggle_left").click(function(e) {
        var $parent = $(this).parent("nav");
        $parent.toggleClass("open_left");
        if ($(".open_right").length > 0 && $(".open_left").length == 0) {
            $(".textarea").css("width", "75%");
            $(".ep-tem-area").css("width", "0");
            $(".resource-area").css("width", "20%");
        } else if ($(".open_left").length > 0 && $(".open_right").length > 0) {
            $(".textarea").css("width", "55%");
            $(".ep-tem-area").css("width", "20%");
        } else if ($(".open_left").length > 0) {
            $(".textarea").css("width", "75%");
            $(".ep-tem-area").css("width", "20%");
        } else if ($(".open_left").length == 0) {
            $(".textarea").css("width", "95%");
            $(".ep-tem-area").css("width", "0");
        }
        e.preventDefault();
    });
});
