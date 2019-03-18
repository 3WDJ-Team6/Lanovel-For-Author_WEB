var commands = [
{
	"cmd": "italic",
    "name": "기울이기"
}, {
    "cmd": "bold",
    "name": "굵게"
}, {
	"cmd": "createLink",
    "val": "https://youtu.be/BXcUred6iXc?t=14",
    "name": "링크달기"
}, {
	"cmd": "unlink",
    "name": "링크지우기"
}, {
	"cmd": "fontSize",
    "val": "20",
    "name": "글자크기"
}, {
    "cmd": "indent",
    "name": "우로밀기"
},{
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
	var cmd = commandRelation[cmdKey];
	val = (typeof cmd.val !== "undefined") ? prompt("", cmd.val) : "";
	document.execCommand(cmd.cmd, false, (val || ""));
}

function init() {
	var html = '',
		template = '<span class="btn tool-btn" onmousedown="event.preventDefault();" onclick="doCommand(\'%cmd%\')">%nam%</span>';
	commands.map(function(command, i) {
		commandRelation[command.cmd] = command;
		var temp = template;
        temp = temp.replace(/%cmd%/gi, command.cmd);
        temp = temp.replace(/%nam%/gi, command.name);
		html+=temp;
	});
	document.querySelector(".tool-btns").innerHTML = html;
}

init();