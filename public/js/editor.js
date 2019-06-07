// 글작업 팝업버튼생성
var commands = [{
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
        desc: "링크를 추가하거나 텍스트를 드래그해서 링크를 달 수 있습니다."
    },
    {
        cmd: "unlink",
    },
    {
        cmd: "fontSize",
        val: "3",
        desc: "1(가장 작음)~7(가장 큼) 중 하나를 선택해 크기를 조절할 수 있습니다."
    },
    {
        cmd: "indent",
    },
    {
        cmd: "outdent",
    },
    {
        cmd: "justifyLeft",
    },
    {
        cmd: "justifyCenter",
    },
    {
        cmd: "justifyRight",
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
    commands.map(function (command, i) {
        commandRelation[command.cmd] = command;
        var temp = template;
        temp = temp.replace(/%cmd%/gi, command.cmd);
        html += temp;
    });
    document.querySelector(".tool_popup_box").innerHTML = html;
}

init();
// 글작업 팝업버튼생성//

//텍스트 셀렉팅 팝업 도구
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
    hiddenPopbtn: function () {
        if (popbtnobj != null) {
            popbtnobj.style.display = "none";
        }
    },
    //팝업창
    popopen: function (e) {
        var event = window.event || e;

        var kwd = getSelectText();
        console.log(kwd);

        if (kwd.length <= 0) return;

        //팝업창 보이기
        popbtnobj.style.display = "block";

        //마우스 x,y좌표 구하기
        var mouseX = event.clientX;
        var mouseY = event.clientY;
        mouseX += getScrollLeft();
        mouseY += getScrollTop();
        popbtnobj.style.top = mouseY + -30 + "px";
        popbtnobj.style.left = mouseX + "px";
    }
};
//마우스로 긁은 TEXT
function getSelectText() {
    var gST = "";
    if (window.getSelection) {
        gST = window.getSelection();
    } else if (document.getSelection) {
        gST = document.getSelection();
    } else if (document.selection) {
        gST = document.selection.createRange().text;
    }

    gST = String(gST);
    gST.replace(/^\s+|\s+$/g, ""); //trim

    return gST;
}

//스크롤된 Left 구하기
function getScrollLeft() {
    var dd = document.documentElement;
    console.log(dd);
    var bd = document.body;
    console.log(bd);


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

//에디터내 목차 추가
function popupInEditor(num) {
    var url = "/content_create_in_editor/" + num;
    var option = "width=600, height=300, top=100";
    window.open(url, "", option);
}
//에디터내 목차 추가//

//에디터내 목차 수정
function popupEdit(num) {
    var url = "/content_edit_in_editor/" + num;
    var option = "width=600, height=300, top=100";
    window.open(url, "", option);
}
//에디터내 목차 수정//

//메모팝업
// function memoPopup(e, idNum) {
//     var top = e.clientY + 10;
//     var left = e.clientX + 10;
//     console.log("memoPopup실행되고있나");
//     console.log(idNum);

//     $("#memoPopupId" + idNum)
//         .toggle()
//         .css({
//             top: top,
//             left: left
//         });
// }

// var memoViewId = 1;
// var memoPopupId = 1;

// function memoBalloon(e) {
//     var span = document.createElement("span");
//     var top = e.clientY - 53;
//     var back = ["#ffc", "#cfc", "#ccf"];
//     var rand = back[Math.floor(Math.random() * back.length)];

//     console.log(rand);
//     if (window.getSelection) {
//         var txt = window.getSelection();
//         if (txt.rangeCount) {
//             var range = txt.getRangeAt(0).cloneRange();
//             range.surroundContents(span);
//             txt.removeAllRanges();
//             txt.addRange(range);
//             if (
//                 !$(".textarea span:contains(" + txt + ")").hasClass(
//                     "memoballoon"
//                 )
//             ) {
//                 $(".textarea span:contains(" + txt + ")").addClass(
//                     "memoballoon"
//                 );
//                 $(".textarea span:contains(" + txt + ")").prepend(
//                     "<div id=" +
//                         "'memoViewId" +
//                         memoViewId +
//                         "'" +
//                         "class='balloon' style='top:" +
//                         top +
//                         "px;' onclick='memoPopup(event," +
//                         memoViewId +
//                         ");'></div>" +
//                         "<div id=" +
//                         "'memoPopupId" +
//                         memoPopupId +
//                         "'" +
//                         "class='memoPopup' contenteditable='false' style='background-color:" +
//                         rand +
//                         "'>" +
//                         "<form method='POST' action='/store_memo/" +
//                         num_of_work +
//                         "/" +
//                         memoViewId +
//                         "'>" +
//                         "<textarea name='content_of_memo' class='underline' autocorrect='false'>" +
//                         "</textarea>" +
//                         "<span>유저이름</span>" +
//                         "<button type='submit' class='memoSave'>" +
//                         "<span class='memoSaveSpan'><span>" +
//                         "</button>" +
//                         "</form>" +
//                         "</div>"
//                 );
//                 $(".textarea span:contains(" + txt + ")").css(
//                     "background-color",
//                     "yellow"
//                 );
//                 memoViewId++;
//                 memoPopupId++;
//             } else if (
//                 $(".textarea span:contains(" + txt + ")").hasClass(
//                     "memoballoon"
//                 )
//             ) {
//                 console.log("실행되고잇니hasClass");
//             }
//         }
//     }
// }
//메모팝업//

//에피소드 추가
function addEpisode(sub, num) {
    console.log("실행됬냐" + sub);
    $(".ep-list").append("<a href=/editor/" + num + ">- " + sub + "</a><br>");
}
//에피소드 추가//

//에피소드 수정
function editEpisode(chgsub, orisub) {
    console.log("바뀐제목 : " + chgsub + " 원래제목 : " + orisub);
    $(".ep-title").text(chgsub);
    $(".ep-list a").each(function () {
        var text = $(this).text();
        console.log("text : " + text);
        $(this)
            .text(text.replace(orisub, chgsub))
            .append("<br>");
    });
}
//에피소드 수정//

//이미지에 추가된 음악 재생 및 정지
let isPlaying = false;
let audioPlay_num = null;

function audioPlay(e) {
    audioPlay_num = e.target.nextElementSibling.id;
    console.log(audioPlay_num);
    var audio = document.getElementById(audioPlay_num);
    console.log(audio);

    if (isPlaying) {
        audio.pause();
        isPlaying = false;
    } else {
        audio.play();
        isPlaying = true;
    }
}
//이미지에 추가된 음악 재생 및 정지//

//리소스파일 리스팅
getResource();
let folder = "";
var chng_text = "";
var folder_name = "";
var folder_name_ko = "";

function getResource() {
    $.ajax({
        type: "GET",
        url: "/getDir/" + num_of_work, //private, public, 나중에 책의 num값도 넘겨줘야함
        dataType: "json",
        error: function (e) {
            console.log(e);
            throw new Error("실-패");
        },
        success: function (data) {
            console.log(data);
            $("#resource-feild").html("");
            for (var i = 0; i < 2; i++) {
                folder_name = Object.keys(data)[i].replace("_FOLDERS", "");
                // folder_name = Object.keys(data)[i];
                console.log(folder_name);
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
                    "' class='obj' onclick='getFolders()'><span class='obj_folder' style='background-image: url(\"/image/tool_icon/folder_icon.png\");background-size: 120px 120px;'></span><span class='obj_name'>" +
                    folder_name_ko +
                    "</span></span>"
                );
            }
        }
    });
}
var folder_name_kinds = "";

function getFolders() {
    $(document).on("click", ".obj, .back.folderkinds", function () {
        if (this.id == "obj_0") {
            folder = "private";
        } else if (this.id == "obj_1") {
            folder = "public";
        }
        $.ajax({
            type: "GET",
            url: "/getDir/" + num_of_work + "/" + folder,
            dataType: "json",
            error: function (data) {
                console.log(22222222);
                console.log(data);
                throw new Error("실-패");
            },
            success: function (data) {
                switch (folder) {
                    case "private":
                        folder_name_ko = "개인 폴더";
                        break;
                    case "public":
                        folder_name_ko = "공용 폴더";
                        break;
                    default:
                        break;
                }
                console.log(111111111);
                console.log(data);
                console.log("folder : " + folder);
                console.log("folder_name_ko : " + folder_name_ko);
                $("#resource-feild").html("");
                $("#resource-feild").prepend(
                    "<span class='folder_name'>" +
                    folder_name_ko +
                    "</span>" +
                    "<span class='back foldername'>" +
                    "<svg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' version='1.1' id='Layer_1' x='0px' y='0px' viewBox='0 0 512.001 512.001' style='enable-background:new 0 0 512.001 512.001;' xml:space='preserve' width='32px' height='32px' class=''><g><g>" +
                    "<g>" +
                    "<path d='M384.834,180.699c-0.698,0-348.733,0-348.733,0l73.326-82.187c4.755-5.33,4.289-13.505-1.041-18.26    c-5.328-4.754-13.505-4.29-18.26,1.041l-82.582,92.56c-10.059,11.278-10.058,28.282,0.001,39.557l82.582,92.561    c2.556,2.865,6.097,4.323,9.654,4.323c3.064,0,6.139-1.083,8.606-3.282c5.33-4.755,5.795-12.93,1.041-18.26l-73.326-82.188    c0,0,348.034,0,348.733,0c55.858,0,101.3,45.444,101.3,101.3s-45.443,101.3-101.3,101.3h-61.58    c-7.143,0-12.933,5.791-12.933,12.933c0,7.142,5.79,12.933,12.933,12.933h61.58c70.12,0,127.166-57.046,127.166-127.166    C512,237.745,454.954,180.699,384.834,180.699' data-original='#000000' class='active-path'" +
                    "data-old_color='#B7CBFC' fill='#476ACD'/>" +
                    "</g>" +
                    "</span>"
                );
                if (folder == "private") {
                    for (var i = 0; i < data.length - 1; i++) {
                        folder_name = data[i];
                        console.log(folder_name);
                        folder_name = folder_name.split("/");
                        console.log(folder_name);
                        folder_name = folder_name[data.length - 3];
                        console.log(folder_name);
                        switch (folder_name) {
                            case "video":
                                folder_name_kinds = folder_name.replace(
                                    "video",
                                    "동영상"
                                );
                                break;
                            case "sound":
                                folder_name_kinds = folder_name.replace(
                                    "sound",
                                    "효과음"
                                );
                                break;
                            case "purchase":
                                folder_name_kinds = folder_name.replace(
                                    "purchase",
                                    "구매"
                                );
                                break;
                            case "images":
                                folder_name_kinds = folder_name.replace(
                                    "images",
                                    "이미지"
                                );
                                break;
                            default:
                                // console.log(folder_name);
                                break;
                        }
                        $("#resource-feild").append(
                            "<span id='obj_" +
                            i +
                            "' class='obj_kinds'><span class='obj_folder' style='background-image: url(\"/image/tool_icon/folder_icon.png\");background-size: 120px 120px;'></span><span class='obj_name'>" +
                            folder_name_kinds +
                            "</span>" +
                            "</span>"
                        );
                    }
                } else {
                    for (var i = 0; i < data.length; i++) {
                        folder_name = data[i];
                        console.log("folder_name1 : " + folder_name);
                        folder_name = folder_name.split("/");
                        console.log("folder_name2 : " + folder_name);
                        folder_name = folder_name[data.length - 4];
                        console.log("folder_name3 : " + folder_name);
                        switch (folder_name) {
                            case "audio":
                                folder_name_kinds = folder_name.replace(
                                    "audio",
                                    "효과음"
                                );
                                break;
                            case "images":
                                folder_name_kinds = folder_name.replace(
                                    "images",
                                    "이미지"
                                );
                                break;
                            case "video":
                                folder_name_kinds = folder_name.replace(
                                    "video",
                                    "동영상"
                                );
                                break;
                            default:
                                console.log(folder_name);
                                break;
                        }
                        if (folder_name == "images") {
                            $("#resource-feild").append(
                                "<span id='obj_" +
                                i +
                                "' class='obj_kinds'><span class='obj_folder' style='background-image: url(\"/image/tool_icon/folder_icon.png\");background-size: 120px 120px;'></span><span class='obj_name'>" +
                                folder_name_kinds +
                                "</span>" +
                                "</span>"
                            );
                        } else {}
                    }
                }
            }
        });
    });
}

var folder_kinds = "";
var folder_files = "";
var folder_input_name = "";
$(document).on("click", ".obj_kinds", function () {
    if (folder == "private") {
        if (this.id == "obj_0") {
            folder_kinds = "images";
            folder_name_kinds = "이미지";
        } else if (this.id == "obj_1") {
            folder_kinds = "purchase";
            folder_name_kinds = "구매";
        } else if (this.id == "obj_2") {
            folder_kinds = "sound";
            folder_name_kinds = "효과음";
        } else if (this.id == "obj_3") {
            folder_kinds = "video";
            folder_name_kinds = "동영상";
        }
    } else if (folder == "public") {
        if (this.id == "obj_0") {
            folder_kinds = "audio";
            folder_name_kinds = "효과음";
        } else if (this.id == "obj_3") {
            folder_kinds = "images";
            folder_name_kinds = "이미지";
        } else if (this.id == "obj_6") {
            folder_kinds = "video";
            folder_name_kinds = "동영상";
        }
    }
    console.log(folder);
    switch (folder) {
        case "private":
            folder_files = "privateFiles";
            break;
        case "public":
            folder_files = "publicFiles";
            break;
        default:
            break;
    }
    $.ajax({
        type: "GET",
        url: "/getDir/" + num_of_work + "/" + folder_files + "/" + folder_kinds,
        dataType: "json",
        error: function (data) {
            console.log(
                "/getDir/" +
                num_of_work +
                "/" +
                folder_files +
                "/" +
                folder_kinds
            );
            console.log(44444444);
            console.log(data);
            throw new Error("실-패");
        },
        success: function (data) {
            console.log(
                "/getDir/" +
                num_of_work +
                "/" +
                folder_files +
                "/" +
                folder_kinds
            );
            console.log(33333333);
            console.log(data);
            data.reverse();
            console.log("folder : " + folder);
            $("#resource-feild").html("");
            $("#resource-feild").prepend(
                "<span class='folder_name'>" +
                folder_name_kinds +
                "</span>" +
                "<span class='back folderkinds'>" +
                "<svg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' version='1.1' id='Layer_1' x='0px' y='0px' viewBox='0 0 512.001 512.001' style='enable-background:new 0 0 512.001 512.001;' xml:space='preserve' width='32px' height='32px' class=''><g><g>" +
                "<g>" +
                "<path d='M384.834,180.699c-0.698,0-348.733,0-348.733,0l73.326-82.187c4.755-5.33,4.289-13.505-1.041-18.26    c-5.328-4.754-13.505-4.29-18.26,1.041l-82.582,92.56c-10.059,11.278-10.058,28.282,0.001,39.557l82.582,92.561    c2.556,2.865,6.097,4.323,9.654,4.323c3.064,0,6.139-1.083,8.606-3.282c5.33-4.755,5.795-12.93,1.041-18.26l-73.326-82.188    c0,0,348.034,0,348.733,0c55.858,0,101.3,45.444,101.3,101.3s-45.443,101.3-101.3,101.3h-61.58    c-7.143,0-12.933,5.791-12.933,12.933c0,7.142,5.79,12.933,12.933,12.933h61.58c70.12,0,127.166-57.046,127.166-127.166    C512,237.745,454.954,180.699,384.834,180.699' data-original='#000000' class='active-path'" +
                "data-old_color='#B7CBFC' fill='#476ACD'/>" +
                "</g>" +
                "</span>"
            );
            if (folder_kinds == "images") {
                folder_input_name = "image";
            } else {
                folder_input_name = "file";
            }

            if (folder_kinds == "purchase") {
                $(".back").after("<div id='obj_feild'></div>");
            } else {
                $(".back").after(
                    "<div class='upload_loading'><label for='image' class='upload_label'>+</label><input type='file' name='" +
                    folder_input_name +
                    "' id='image' /></div><div id='obj_feild'></div>"
                );
            }

            if (folder_kinds == "images" || folder_kinds == "purchase") {
                $.each(data, function (index, item) {
                    console.log("item.name : " + item.name);
                    console.log("item.src : " + item.src);
                    console.log("index : " + index);
                    chng_text = item.name.substr(0, 9) + "...";
                    $("#obj_feild").append(
                        "<span id='objLi_" +
                        index +
                        "' class='obj_file'>" +
                        "<img id='obj_" +
                        index +
                        "' src='" +
                        item.src +
                        "' servername='" +
                        item.fileName +
                        "' alt='alt" +
                        "' class='obj_thum' /><span class='obj_name' title='" +
                        item.name +
                        "'>" +
                        chng_text +
                        "</span></span>"
                    );
                });
            } else if (folder_kinds == "video") {
                $.each(data, function (index, item) {
                    chng_text = item.name.substr(0, 9) + "...";
                    $("#obj_feild").append(
                        "<span id='objLi_" +
                        index +
                        "' class='obj_file'>" +
                        "<img id='obj_" +
                        index +
                        "' src='/image/tool_icon/mp4_icon.png' " +
                        "source='" +
                        item.src +
                        "' servername='" +
                        item.fileName +
                        "' class='mp4_icon' type='video/webm' />" +
                        // "</video>" +
                        "<span class='obj_name' title='" +
                        item.name +
                        "'>" +
                        chng_text +
                        "</span></span>"
                    );
                });
            } else {
                $.each(data, function (index, item) {
                    chng_text = item.name.substr(0, 9) + "...";
                    $("#obj_feild").append(
                        "<span id='objLi_" +
                        index +
                        "' class='obj_file'>" +
                        "<span id='play" +
                        index +
                        "()' src='" +
                        item.src +
                        "' servername='" +
                        item.fileName +
                        "' class='obj_thum mp3_icon'></span>" +
                        "<span class='obj_name' title='" +
                        item.name +
                        "'>" +
                        chng_text +
                        "</span></span>"
                    );
                });
            }
        }
    });
});
$(document).on("click", ".back.foldername", function () {
    console.log("백눌렀지?");
    getResource();
});
//리소스파일 리스팅//

//파일추가
let appendId = null;
var publicUrl = "";
$(document).on("change", 'input[type="file"]', function (event) {
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
            publicUrl = "/images/" + path + "/" + num_of_work;
            break;
        case "private":
            publicUrl =
                "/images/" + path + "/" + num_of_work + "/" + folder_kinds;
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
        success: function () {
            $("span").remove("#file_loading");
        },
        beforeSend: function () {
            $("#image").after("<span id='file_loading'></span>");
        },
        complete: function () {
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
        error: function (e) {
            console.log(e + "에러");
        }
    });
});
//파일추가//

//파일 우클릭 & 삭제
var image_id = "";
var img = "";
var image_name = "";
var path = "";
var server_name = "";
var publicUrl = "";
$(document).on("contextmenu", ".obj_file", function () {
    event.preventDefault();
    img = $(this)
        .children(".obj_thum")
        .attr("src");
    image_name = $(this)
        .children(".obj_name")
        .attr("title");
    path = img
        .replace("https://s3.ap-northeast-2.amazonaws.com/lanovebucket/", "")
        .replace("" + image_name, "");
    server_name = $(this)
        .children(".obj_thum")
        .attr("servername");
    image_id = $(this).attr("id");
    console.log("server_name : " + server_name);
    console.log("img : " + img);
    console.log("img_path : " + path);
    console.log("image_name : " + image_name);
    console.log("folder_kinds : " + folder_kinds);

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
        .bind("click", function () {
            $("div.custom-menu").remove();
        });
    $(document).on("click", "#file-delete", function () {
        console.log("image_id : " + image_id);

        switch (folder) {
            case "public":
                publicUrl =
                    "/images/" + server_name + "/" + path + "/" + num_of_work;
                break;
            case "private":
                // publicUrl = "/images/" + folder + "/" + path + image_name;
                publicUrl =
                    "/images/" +
                    server_name +
                    "/" +
                    folder +
                    "/" +
                    folder_kinds;
                // publicUrl = "/images/" + server_name;
                break;
            default:
                break;
        }
        console.log("publicUrl : " + publicUrl);

        $.ajax({
            async: false,
            method: "delete",
            url: publicUrl,
            type: "POST",
            success: function () {
                console.log(image_name);
                $("#" + image_id).remove();
            },
            error: function () {
                console.log("에러");
            }
        });
    });
    $(document).on("click", "body", function () {
        $("div.custom-menu").remove();
    });
});
//파일 우클릭 & 삭제//

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    //툴 팝업 링크해제 뒤로 한칸내리는역할
    $("#unlink").after("<div></div>");
    //툴 팝업 링크해제 뒤로 한칸내리는역할//

    //글쓰는 곳에서 엔터키누르면 앞에 태그에따라 자동생성되던 태그를 p태그로 변경
    // $(document).on("keyup", ".textarea", function(e) {
    //     if (e.keyCode === 13) {
    //         document.execCommand("formatBlock", false, "p");
    //     }
    // });
    //글쓰는 곳에서 엔터키누르면 앞에 태그에따라 자동생성되던 태그를 p태그로 변경//
    // $(document).on("keyup", ".textarea", function (e) {
    //     if (e.keyCode === 13) {
    //         if ($(".textarea > .text_p > br").length) {
    //             $("br").replaceWith("-");
    //         }
    //     }
    // });
    //포커스
    let focus_flag = false;
    $(document).on("mousedown", ".text_p", function () {
        if ($(".user_focus").length) {
            console.log("포커스풀림");
            $(".user_focus").remove();
            focus_flag = false;
        }
        if (focus_flag === false) {
            console.log("포커스됨");
            $(this).append(
                "<span class='user_focus " +
                userRoles +
                " ' contentEditable='false'>" +
                userNickname +
                "</span>"
            );
            focus_flag = true;
        } else if (focus_flag === true) {
            console.log("포커스풀림");
            $(".user_focus").remove();
            focus_flag = false;
        }
    });
    //포커스//

    //에피소드관리
    $("#ep").click(function () {
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
    $("#tem").click(function () {
        if ($("div").hasClass("ep")) {
            $(".ep").hide();
        }
        $(".tem").show();
    });
    //템플릿//

    //리소스 파일을 textarea에 넣으면 class를 resize로 변경
    var imgId = "";
    var mp4Id = "";
    var resize_num = null;
    var resize_mp4 = null;
    document
        .getElementById("popup_result")
        .addEventListener("input", function (e) {
            resize_num = $(".resize").length;
            resize_mp4 = $(".resize_mp4").length;
            imgId = $(".textarea .obj_thum").attr("id");
            imgId = imgId + resize_num;
            $(".textarea .obj_thum").attr("id", "" + imgId + "");
            $(".textarea .obj_thum")
                .attr("class", "resize")
                .draggable();
            mp4Id = $(".textarea .mp4_icon").attr("id");
            mp4Id = mp4Id + resize_mp4;
            $(".textarea .mp4_icon").attr("id", "" + mp4Id + "");
            $(".textarea .mp4_icon").attr("class", "resize_mp4");
            $(".resize_mp4").replaceWith(
                "<video id='obj_12' controls src='https://s3.ap-northeast-2.amazonaws.com/lanovebucket/Author/authorID@google.com/video/1557648920Sakurasou_ED.mp4' servername='1557648920Sakurasou_ED.mp4' class='resize' type='video/webm'/>"
            );
        });
    //리소스 파일을 textarea에 넣으면 class를 resize로 변경//

    //resize된 파일을 클릭했을 때
    var tool_imgId = "";
    $(document).on("click", ".resize, .css_eft", function () {
        tool_imgId = $(this).attr("id");
        console.log(tool_imgId);
    });
    //resize된 파일을 클릭했을 때//

    //resize된 파일을 우클릭 및 삭제
    var tool_image_id = "";
    $(document).on("contextmenu", ".tem_effect, .resize", function () {
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
            .bind("click", function () {
                $("div.custom-menu").remove();
            });
        $(document).on("click", "#file-delete", function () {
            if (tool_image_id.parent().hasClass("tem_effect")) {
                tool_image_id.parent().remove();
                tool_image_id.children().remove();
            }
            tool_image_id.remove();
        });
        $(document).on("click", "body", function () {
            $("div.custom-menu").remove();
        });
    });
    //resize된 파일을 우클릭 및 삭제//

    //미리보기+루비
    $("#pre-btn").click(function () {
        $(".textarea").each(function () {
            var text = $(".textarea").html();
            $("#result").html(text);
            $("#result").html(
                $("#result")
                .html()
                .replace(
                    /([一-龠]+)（([ぁ-んァ-ヶ]+?)）/g,
                    "<ruby>$1<rt>$2</rt></ruby>"
                )
                .replace(
                    /class="resize"/g,
                    "style='width:100%;height:auto'"
                )
            );
        });
    });
    //미리보기+루비//

    //a태그 드래그 금지
    $("body").hover(function () {
        $("a").attr("draggable", "false");
    });
    //a태그 드래그 금지//

    //템플릿
    //css 이펙트 효과
    var tool_imgId_width = 0;
    var tool_imgId_height = 0;
    var css_eft_val = "";
    $(".css_eft_control").click(function () {
        css_eft_val = $(this).attr("id");
        // css_eft_val = $(event.target);
        // css_eft_val = css_eft_val.attr("id");
        console.log(css_eft_val);
        tool_imgId_width = $("#" + tool_imgId).width();
        tool_imgId_height = $("#" + tool_imgId).height();
        console.log($($("#" + tool_imgId).prev()));
        if ($("#" + tool_imgId).hasClass("css_eft")) {
            console.log("이미 새로고침하고 클래스 씌워져있어");
            switch (css_eft_val) {
                case "css_eft_cB1": //벚꽃1
                    $("#" + tool_imgId).attr("id", "cherryBlossom1");
                    break;
                case "css_eft_cB2": //벚꽃2
                    $("#" + tool_imgId).attr("id", "cherryBlossom2");
                    break;
                case "css_eft_rain": //비
                    $("#" + tool_imgId).attr("id", "rain");
                    break;
                case "css_eft_snow": //눈
                    $("#" + tool_imgId).attr("id", "snow");
                    break;
                case "css_eft_starlight": //반짝임
                    $("#" + tool_imgId).attr("id", "starlight");
                    break;
                case "css_eft_yellowstar": //노란별
                    $("#" + tool_imgId).attr("id", "yellowstar");
                    break;
                case "css_eft_lightning": //번개
                    $("#" + tool_imgId).attr("id", "lightning");
                    break;
                default:
                    break;
            }
        } else if (
            $("#" + tool_imgId)
            .prev()
            .hasClass("css_eft")
        ) {
            console.log("이미 씌운거있어서 따른효과로 바꿨어");

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
                default:
                    break;
            }
        } else {
            console.log("없어서 효과 입혔어");

            $("#" + tool_imgId).wrap("<span class='tem_effect'></span>");
            switch (css_eft_val) {
                case "css_eft_cB1": //벚꽃1
                    $("#" + tool_imgId).before(
                        "<span id='cherryBlossom1' class='css_eft'></span>"
                    );
                    break;
                case "css_eft_cB2": //벚꽃2
                    $("#" + tool_imgId).before(
                        "<span id='cherryBlossom2' class='css_eft'></span>"
                    );
                    break;
                case "css_eft_rain": //비
                    $("#" + tool_imgId).before(
                        "<span id='rain' class='css_eft'></span>"
                    );
                    break;
                case "css_eft_snow": //눈
                    $("#" + tool_imgId).before(
                        "<span id='snow' class='css_eft'></span>"
                    );
                    break;
                case "css_eft_starlight": //반짝임
                    $("#" + tool_imgId).before(
                        "<span id='starlight' class='css_eft'></span>"
                    );
                    break;
                case "css_eft_yellowstar": //노란별
                    $("#" + tool_imgId).before(
                        "<span id='yellowstar' class='css_eft'></span>"
                    );
                    break;
                case "css_eft_lightning": //번개
                    $("#" + tool_imgId).before(
                        "<span id='lightning' class='css_eft'></span>"
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
    });
    //css 이펙트 효과//

    //크게, 작게, 원래사이즈
    var size_val = "";
    $(".size_control").click(function () {
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
                    height: tool_imgId_height
                    // "background-size": "auto"
                });
        }
    });
    //크게, 작게, 원래사이즈//

    //소리 추가
    var audio_val = "";
    var audio_num = null;
    var audio_src = "";
    $(document).on("click", ".mp3_icon", function () {
        audio_val = $(this).attr("id");
        audio_num = audio_val.replace("play", "").replace("()", "");
        audio_src = $(this).attr("src");
        if ($("#" + tool_imgId).attr("onclick")) {
            $("#" + tool_imgId).removeAttr("onclick");
            $(".speaker").remove();
        } else if ($("#" + tool_imgId).hasClass("css_eft")) {
            $("#" + tool_imgId).attr("onclick", "audioPlay(event)");
            $("#" + tool_imgId).after(
                "<audio id='audio" +
                audio_num +
                "' src='" +
                audio_src +
                "'></audio>"
            );
            $("#" + tool_imgId)
                .next()
                .next()
                .after(
                    "<span class='speaker'>" +
                    "<img src='/images/tool_icon/speaker_icon.png' alt='alt' style='width:24px;height:auto;' />" +
                    "</span>"
                );
        } else {
            $("#" + tool_imgId).attr("onclick", "audioPlay(event)");
            $("#" + tool_imgId).after(
                "<audio id='audio" +
                audio_num +
                "' src='" +
                audio_src +
                "'></audio>"
            );
            $("#" + tool_imgId)
                .next()
                .after(
                    "<span class='speaker'>" +
                    "<img src='/images/tool_icon/speaker_icon.png' alt='alt' style='width:24px;height:auto;' />" +
                    "</span>"
                );
        }
    });
    //소리 추가

    //템플릿//

    //메모
    // var memoViewId = 0;
    // $("#memo").click(function () {
    //     $(".textarea").prepend(
    //         "<div id=" +
    //         "'memoViewId" +
    //         memoViewId +
    //         "'" +
    //         " class='balloon' onclick='memoPopup(event);'></div>"
    //     );
    //     memoViewId++;
    //     $(".balloon").draggable();
    //     $("#memoPopup").append(
    //         '<span><form><input type="text" name="edit" style="width:160px;float:right;"' +
    //         'readonly required><input style="float:right;" type="submit" name="memosave" value="save"></form></span>'
    //     );
    //     $('[name="edit"]').on("click", function () {
    //         // var prev = $(this).prev('input'),
    //         var ro = $(this).prop("readonly");
    //         $(this)
    //             .prop("readonly", !ro)
    //             .focus();
    //         // $(this).val(ro ? 'save' : 'edit');
    //     });
    // });

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

    //처음에 윈도우창 사이즈 값 저장
    var window_width = null;
    var window_height = null;
    $(window).ready(function () {
        window_width = $(window).width();
        window_height = $(window).height();
    });
    //처음에 윈도우창 사이즈 값 저장//

    //윈도우창크기 바뀔때마다 사이즈 값 저장
    $(window).on("resize", function () {
        window_width = $(window).width();
        window_height = $(window).height();
    });
    //윈도우창크기 바뀔때마다 사이즈 값 저장//

    //오른쪽 사이드바
    $("#menuToggle_right").click(function (e) {
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
            //세로가 최소 700px를 넘거나 최소900px를 넘을 때
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
    $("#menuToggle_left").click(function (e) {
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
            //세로가 최소 700px를 넘거나 최소900px 넘을 때
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
