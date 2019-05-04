// 버튼생성
var commands = [
    {
        cmd: "bold"
    },
    {
        cmd: "italic"
    },
    {
        cmd: "underline"
    },
    {
        cmd: "strikeThrough"
    },
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
    // {
    //     cmd: "insertHorizontalRule",
    //     name: "가로줄"
    // },

    {
        cmd: "justifyLeft",
        name: "좌측정렬"
    },
    {
        cmd: "justifyCenter",
        name: "중앙정렬"
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
            '<button class="tool_popup" id="%cmd%" onclick="doCommand(\'%cmd%\')"></button>';
    commands.map(function(command, i) {
        commandRelation[command.cmd] = command;
        var temp = template;
        temp = temp.replace(/%cmd%/gi, command.cmd);
        // temp = temp.replace(/%nam%/gi, command.name);
        html += temp;
    });
    document.querySelector(".tool_popup_box").innerHTML = html;
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

//이미지에 추가된 음악 재생 및 정지
var isPlaying = false;

function play1() {
    var audio = document.getElementById("audio1");
    if (isPlaying) {
        audio.pause();
        isPlaying = false;
    } else {
        audio.play();
        isPlaying = true;
    }
}
//이미지에 추가된 음악 재생//

$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    $("#unlink").after("<div></div>");

    $(".textarea").keyup = e => {
        e = e || window.event;
        if (e.keyCode === 13) document.execCommand("formatBlock", false, "p");
    };

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

    //리소스 출력
    // $('#justifyRight').after('<span class="btn tool-btn" id="resource">리소스</span>');
    // $("#justifyRight").after(
    //     "<span class='btn tool-btn' id='memo'>메모</span>"
    // );

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
    //템플릿//

    //리소스파일 리스팅
    let folder = "";
    var chng_text = "";
    var folder_name = "";
    var folder_name_ko = "";

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
                    switch (folder_name) {
                        case "PUBLIC":
                            folder_name_ko = folder_name.replace(
                                "PUBLIC",
                                "공용 폴더"
                            );
                            break;
                        case "PRIVATE":
                            folder_name_ko = folder_name.replace(
                                "PRIVATE",
                                "개인 폴더"
                            );
                            break;
                        default:
                            console.log(folder_name);
                            break;
                    }
                    console.log("폴더이름 : " + folder_name_ko);
                    $("#resource-feild").append(
                        "<span id='obj_" +
                            i +
                            "' class='obj'><span class='obj_folder' style='background-image: url(\"/image/tool_icon/folder_icon.png\");background-size: 120px 120px;'></span><span class='obj_name'>" +
                            folder_name_ko +
                            "</span></span>"
                    );
                }
            }
        });
    }
    $(document).on("click", ".obj", function() {
        if (this.id == "obj_0") {
            folder = "private";
            folder_name_ko = "개인 폴더";
        } else if (this.id == "obj_1") {
            folder = "public";
            folder_name_ko = "공용 폴더";
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
                $("#resource-feild").prepend(
                    "<span class='folder_name'>" +
                        folder_name_ko +
                        "</span>" +
                        "<span class='back'>" +
                        "<svg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' version='1.1' id='Layer_1' x='0px' y='0px' viewBox='0 0 512.001 512.001' style='enable-background:new 0 0 512.001 512.001;' xml:space='preserve' width='32px' height='32px' class=''><g><g>" +
                        "<g>" +
                        "<path d='M384.834,180.699c-0.698,0-348.733,0-348.733,0l73.326-82.187c4.755-5.33,4.289-13.505-1.041-18.26    c-5.328-4.754-13.505-4.29-18.26,1.041l-82.582,92.56c-10.059,11.278-10.058,28.282,0.001,39.557l82.582,92.561    c2.556,2.865,6.097,4.323,9.654,4.323c3.064,0,6.139-1.083,8.606-3.282c5.33-4.755,5.795-12.93,1.041-18.26l-73.326-82.188    c0,0,348.034,0,348.733,0c55.858,0,101.3,45.444,101.3,101.3s-45.443,101.3-101.3,101.3h-61.58    c-7.143,0-12.933,5.791-12.933,12.933c0,7.142,5.79,12.933,12.933,12.933h61.58c70.12,0,127.166-57.046,127.166-127.166    C512,237.745,454.954,180.699,384.834,180.699' data-original='#000000' class='active-path'" +
                        "data-old_color='#B7CBFC' fill='#476ACD'/>" +
                        "</g>" +
                        "</span>"
                );
                $(".back").after(
                    "<div class='upload_loading'><label for='image' class='upload_label'>+</label><input type='file' name='image' id='image' /></div><div><div id='obj_feild'>"
                );
                $.each(data, function(index, item) {
                    // console.log("item.name : " + item.name);
                    // console.log("item.src : " + item.src);
                    // console.log("index : " + index);
                    chng_text = item.name.substr(0, 9) + "...";
                    $("#obj_feild").append(
                        "<span id='objLi_" +
                            index +
                            "' class='obj_file'><img id='obj_" +
                            index +
                            "' src='" +
                            item.src +
                            "' servername='" +
                            item.fileName +
                            "' class='obj_thum' /><span class='obj_name' title='" +
                            item.name +
                            "'>" +
                            chng_text +
                            "</span></span>"
                    );
                });
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
    let appendId = null;
    $(document).on("change", 'input[type="file"]', function(event) {
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
        var path = folder;
        console.log("path : " + path);
        appendId = $(".obj_file").length;
        switch (path) {
            case "public":
                var publicUrl = "/images/" + path + "/" + num_of_work;
                break;
            case "private":
                var publicUrl = "/images";
                break;
            default:
                break;
        }
        console.log("publicUrl : " + publicUrl);

        $.ajax({
            // public 폴더에 등록할 때 images/public/책번호
            url: publicUrl,
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
                $("#obj_feild").prepend(
                    "<span id='objLi_" +
                        appendId +
                        "' class='obj_file'><img id='obj_" +
                        appendId +
                        "' class='obj_thum' /><span class='obj_name' title='" +
                        file_name +
                        "'>" +
                        chng_name +
                        "</span></span>"
                );
                var output = document.getElementById("objLi_" + appendId);
                var child = output.children[0];
                child.src = URL.createObjectURL(event.target.files[0]);
                // appendId++;
            },
            error: function(e) {
                console.log(e + "에러");
            }
        });
    });
    //파일추가//

    //파일 우클릭 & 삭제
    var image_id = "";
    var img = "";
    var image = "";
    var path = "";
    var server_name = "";
    var publicUrl = "";
    $(document).on("contextmenu", ".obj_file", function() {
        img = $(this)
            .children(".obj_thum")
            .attr("src");
        image = $(this)
            .children(".obj_name")
            .attr("title");
        path = img
            .replace(
                "https://s3.ap-northeast-2.amazonaws.com/lanovebucket/",
                ""
            )
            .replace("" + image, "");
        server_name = $(this)
            .children(".obj_thum")
            .attr("servername");
        image_id = $(this).attr("id");
        console.log("server_name : " + server_name);
        console.log("img : " + img);
        console.log("img_path : " + path);
        console.log("img_name : " + image);

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
            console.log("image_id : " + image_id);

            switch (folder) {
                case "public":
                    publicUrl =
                        "/images/" +
                        server_name +
                        "/" +
                        path +
                        "/" +
                        num_of_work;
                    break;
                case "private":
                    publicUrl = "/images/" + server_name;
                    break;
                default:
                    break;
            }
            console.log("publicUrl : " + publicUrl);

            $.ajax({
                method: "delete",
                url: publicUrl,
                type: "POST",
                success: function(data) {
                    console.log(data);
                    console.log(image);
                    $("#" + image_id).remove();
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

    //파일을 textarea에 넣었을 때
    var imgId = "";
    var resize_num = null;
    document
        .getElementById("popup_result")
        .addEventListener("input", function() {
            resize_num = $(".resize").length;
            console.log(resize_num);

            imgId = $(".textarea .obj_thum").attr("id");
            imgId = imgId + resize_num;
            $(".textarea .obj_thum").attr("id", "" + imgId + "");
            $(".textarea .obj_thum").attr("class", "resize");
        });
    //파일을 textarea에 넣었을 때//

    //resize된 파일을 클릭했을 때
    var tool_imgId = "";
    $(document).on("click", ".resize", function() {
        tool_imgId = $(this).attr("id");
        console.log(tool_imgId);
    });
    //resize된 파일을 클릭했을 때//

    //resize된 파일을 우클릭 및 삭제
    var tool_image_id = "";
    $(document).on("contextmenu", ".tem_effect, .resize", function() {
        // tool_image_id = $(this).attr("id");
        tool_image_id = $(event.target);
        console.log(tool_image_id);

        event.preventDefault();
        if ($(".custom-menu").length) {
            $("div.custom-menu").remove();
        }
        $("div.custom-menu").remove();
        $("<div id='file-delete' class='custom-menu'>삭제</div>")
            .appendTo(".area")
            .css({
                top: event.pageY + "px",
                left: event.pageX + "px"
            })
            .bind("click", function() {
                $("div.custom-menu").remove();
            });
        $(document).on("click", "#file-delete", function() {
            if (tool_image_id.parent().hasClass("tem_effect")) {
                tool_image_id.parent().remove();
                tool_image_id.children().remove();
            }
            tool_image_id.remove();
        });
        $(document).on("click", "body", function() {
            $("div.custom-menu").remove();
        });
    });
    //resize된 파일을 우클릭 및 삭제//

    //미리보기+루비
    $("#pre-btn").click(function() {
        $(".textarea").each(function() {
            var text = $(".textarea").html();
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

    //템플릿
    //css 이펙트 효과
    var tool_imgId_width = 0;
    var tool_imgId_height = 0;
    var css_eft_val = "";
    $(".css_eft_control").click(function() {
        css_eft_val = $(this).attr("id");
        // css_eft_val = $(event.target);
        // css_eft_val = css_eft_val.attr("id");
        console.log(css_eft_val);
        tool_imgId_width = $("#" + tool_imgId).width();
        tool_imgId_height = $("#" + tool_imgId).height();
        console.log($($("#" + tool_imgId).prev()));

        if (
            $("#" + tool_imgId)
                .prev()
                .hasClass("css_eft")
        ) {
            console.log("이미중복있어");

            switch (css_eft_val) {
                case "css_eft_cB1": //벚꽃1
                    $("#" + tool_imgId)
                        .prev()
                        .attr("id", "cherryBlossom1");
                    break;
                case "css_eft_cB2": //벚꽃2
                    $("#" + tool_imgId)
                        .prev()
                        .attr("id", "cherryBlossom2");
                    break;
                case "css_eft_rain": //비
                    $("#" + tool_imgId)
                        .prev()
                        .attr("id", "rain");
                    break;
                case "css_eft_snow": //눈
                    $("#" + tool_imgId)
                        .prev()
                        .attr("id", "snow");
                    break;
                case "css_eft_starlight": //반짝임
                    $("#" + tool_imgId)
                        .prev()
                        .attr("id", "starlight");
                    break;
                case "css_eft_yellowstar": //노란별
                    $("#" + tool_imgId)
                        .prev()
                        .attr("id", "yellowstar");
                    break;
                case "css_eft_lightning": //번개
                    $("#" + tool_imgId)
                        .prev()
                        .attr("id", "lightning");
                    break;
                case "css_eft_fire1": //불1
                    $("#" + tool_imgId)
                        .prev()
                        .attr("id", "fire1");
                    break;
                case "css_eft_fire2": //불2
                    $("#" + tool_imgId)
                        .prev()
                        .attr("id", "fire2");
                    break;
                default:
                    break;
            }
        } else {
            console.log("응없어");

            $("#" + tool_imgId).wrap("<div class='tem_effect'></div>");
            switch (css_eft_val) {
                case "css_eft_cB1": //벚꽃1
                    $("#" + tool_imgId).before(
                        "<div id='cherryBlossom1' class='css_eft'></div>"
                    );
                    break;
                case "css_eft_cB2": //벚꽃2
                    $("#" + tool_imgId).before(
                        "<div id='cherryBlossom2' class='css_eft'></div>"
                    );
                    break;
                case "css_eft_rain": //비
                    $("#" + tool_imgId).before(
                        "<div id='rain' class='css_eft'></div>"
                    );
                    break;
                case "css_eft_snow": //눈
                    $("#" + tool_imgId).before(
                        "<div id='snow' class='css_eft'></div>"
                    );
                    break;
                case "css_eft_starlight": //반짝임
                    $("#" + tool_imgId).before(
                        "<div id='starlight' class='css_eft'></div>"
                    );
                    break;
                case "css_eft_yellowstar": //노란별
                    $("#" + tool_imgId).before(
                        "<div id='yellowstar' class='css_eft'></div>"
                    );
                    break;
                case "css_eft_lightning": //번개
                    $("#" + tool_imgId).before(
                        "<div id='lightning' class='css_eft'></div>"
                    );
                    break;
                case "css_eft_fire1": //불1
                    $("#" + tool_imgId).before(
                        "<div id='fire1' class='css_eft'></div>"
                    );
                    break;
                case "css_eft_fire2": //불2
                    $("#" + tool_imgId).before(
                        "<div id='fire2' class='css_eft'></div>"
                    );
                    break;
                default:
                    break;
            }
        }
        $("#" + tool_imgId)
            .prev()
            .css({
                width: tool_imgId_width,
                height: tool_imgId_height
            });
        // $("#css_eft_cB1").click(function () {
        //     tool_imgId_width = $("#" + tool_imgId).width();
        //     tool_imgId_height = $("#" + tool_imgId).height();
        //     $("#" + tool_imgId).wrap("<div class='tem_effect'></div>");
        //     $("#" + tool_imgId).before("<div id='cherryBlossom1' class='css_eft'></div>");
        //     $("#" + tool_imgId).prev().css({
        //         "width": tool_imgId_width,
        //         "height": tool_imgId_height
        //     });
        // });
    });
    //css 이펙트 효과//

    //크게, 작게, 원래사이즈
    var size_val = "";
    $(".size_control").click(function() {
        size_val = $(this).attr("id");
        console.log(size_val);
        switch (size_val) {
            case "large":
                $("#" + tool_imgId).width($("#" + tool_imgId).width() + 25);
                $("#" + tool_imgId).height($("#" + tool_imgId).height("auto"));
                break;
            case "small":
                $("#" + tool_imgId).width($("#" + tool_imgId).width() - 25);
                $("#" + tool_imgId).height($("#" + tool_imgId).height("auto"));
                break;
            default:
                $("#" + tool_imgId).width($("#" + tool_imgId).width("400px"));
                $("#" + tool_imgId).height($("#" + tool_imgId).height("auto"));
                break;
        }
        if (
            $("#" + tool_imgId)
                .prev()
                .hasClass("css_eft")
        ) {
            tool_imgId_width = $("#" + tool_imgId).width();
            tool_imgId_height = $("#" + tool_imgId).height();
            $("#" + tool_imgId)
                .prev()
                .css({
                    width: tool_imgId_width,
                    height: tool_imgId_height,
                    "background-size": "auto"
                });
        }
    });
    //크게, 작게, 원래사이즈//

    //소리 추가
    $("#play_add1").click(function() {
        if ($("#" + tool_imgId).attr("onclick")) {
            $("#" + tool_imgId).removeAttr("onclick");
            $("#audio1").remove();
        } else {
            $("#" + tool_imgId).attr("onclick", "play1()");
            $("#" + tool_imgId).after(
                "<audio id='audio1' src='https://s3.ap-northeast-2.amazonaws.com/lanovebucket/Author/Author%40test/WorkSpace/%EB%83%A5%EB%A9%8D%EC%9D%B4/OEBPS/audio/%EB%A9%8D%ED%95%98%EB%8B%88+%EC%82%B4%EC%A7%80+%EB%A7%90%EB%9D%BC%EA%B5%AC~.mp3'></audio>"
            );
        }
    });
    //소리 추가

    //템플릿//

    //메모
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
            '<span><form><input type="text" name="edit" style="width:160px;float:right;"' +
                'readonly required><input style="float:right;" type="submit" name="memosave" value="save"></form></span>'
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

    var window_width = null;
    var window_height = null;
    var msg = null;
    //처음에 윈도우창 사이즈 값 저장
    $(window).ready(function() {
        window_width = $(window).width();
        window_height = $(window).height();
    });
    //처음에 윈도우창 사이즈 값 저장//

    //윈도우창크리바뀔때마다 사이즈 값 저장
    $(window).on("resize", function() {
        window_width = $(window).width();
        window_height = $(window).height();
    });
    //윈도우창크리바뀔때마다 사이즈 값 저장//

    //오른쪽 사이드바
    $("#menuToggle_right").click(function(e) {
        var parent = $(this).parent("nav");

        parent.toggleClass("open_right");

        //세로가 최소 700px, 가로가 최소 700px 이면서 최대 899px 이거나 세로가 최소 900px, 가로가 최소700px 이면서 최대958px일때
        if (
            (window_height >= 700 &&
                window_width >= 700 &&
                window_width <= 899) ||
            (window_height >= 900 && window_width >= 700 && window_width <= 958)
        ) {
            if ($(".open_left").length > 0 && $(".open_right").length == 0) {
                $(".textarea").css("width", "70%");
                $(".resource-area").css("width", "0");
                $(".ep-tem-area").css("width", "25%");
            } else if (
                $(".open_right").length > 0 &&
                $(".open_left").length > 0
            ) {
                $(".textarea").css("width", "49%");
                $(".resource-area").css("width", "25%");
            } else if ($(".open_right").length > 0) {
                $(".textarea").css("width", "70%");
                $(".resource-area").css("width", "20%");
            } else if ($(".open_right").length == 0) {
                $(".textarea").css("width", "92%");
                $(".resource-area").css("width", "0");
            }
            e.preventDefault();
            //세로가 최소 700px를 넘거나 최소900px를 넘거나
        } else if (window_height >= 700 || window_height >= 900) {
            if ($(".open_left").length > 0 && $(".open_right").length == 0) {
                $(".textarea").css("width", "75%");
                $(".resource-area").css("width", "0");
                $(".ep-tem-area").css("width", "20%");
            } else if (
                $(".open_right").length > 0 &&
                $(".open_left").length > 0
            ) {
                $(".textarea").css("width", "58%");
                $(".resource-area").css("width", "20%");
            } else if ($(".open_right").length > 0) {
                $(".textarea").css("width", "75%");
                $(".resource-area").css("width", "20%");
            } else if ($(".open_right").length == 0) {
                $(".textarea").css("width", "95%");
                $(".resource-area").css("width", "0");
            }
            e.preventDefault();
        }
    });

    //왼쪽사이드바
    $("#menuToggle_left").click(function(e) {
        var parent = $(this).parent("nav");
        parent.toggleClass("open_left");
        //세로가 최소 700px, 가로가 최소 700px 이면서 최대 899px 이거나 세로가 최소 900px, 가로가 최소700px 이면서 최대958px일때
        if (
            (window_height >= 700 &&
                window_width >= 700 &&
                window_width <= 899) ||
            (window_height >= 900 && window_width >= 700 && window_width <= 958)
        ) {
            if ($(".open_right").length > 0 && $(".open_left").length == 0) {
                $(".textarea").css("width", "67%");
                $(".ep-tem-area").css("width", "0");
                $(".resource-area").css("width", "20%");
            } else if (
                $(".open_left").length > 0 &&
                $(".open_right").length > 0
            ) {
                $(".textarea").css("width", "50%");
                $(".ep-tem-area").css("width", "25%");
            } else if ($(".open_left").length > 0) {
                $(".textarea").css("width", "70%");
                $(".ep-tem-area").css("width", "25%");
            } else if ($(".open_left").length == 0) {
                $(".textarea").css("width", "92%");
                $(".ep-tem-area").css("width", "0");
            }
            e.preventDefault();
            //세로가 최소 700px를 넘거나 최소900px를 넘거나
        } else if (window_height >= 700 || window_height >= 900) {
            if ($(".open_right").length > 0 && $(".open_left").length == 0) {
                $(".textarea").css("width", "75%");
                $(".ep-tem-area").css("width", "0");
                $(".resource-area").css("width", "20%");
            } else if (
                $(".open_left").length > 0 &&
                $(".open_right").length > 0
            ) {
                $(".textarea").css("width", "58%");
                $(".ep-tem-area").css("width", "20%");
            } else if ($(".open_left").length > 0) {
                $(".textarea").css("width", "75%");
                $(".ep-tem-area").css("width", "20%");
            } else if ($(".open_left").length == 0) {
                $(".textarea").css("width", "95%");
                $(".ep-tem-area").css("width", "0");
            }
            e.preventDefault();
        }
    });
});
