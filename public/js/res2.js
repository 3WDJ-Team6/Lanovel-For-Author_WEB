if (typeof AUTO_TITLE != 'undefined' && AUTO_TITLE == true) {
    document.title = location.hostname;
    console.log(1);
    console.log("document.title : " + document.title);
} //실행됨

if (typeof S3_REGION != 'undefined') {
    var BUCKET_URL = 'http://' + location.hostname + '.' + S3_REGION + '.amazonaws.com'; // e.g. just 's3' for us-east-1 region
    console.log(2);
    var BUCKET_WEBSITE_URL = location.protocol + '//' + location.hostname;
} //실행안됨

if (typeof S3BL_IGNORE_PATH == 'undefined' || S3BL_IGNORE_PATH != true) {
    var S3BL_IGNORE_PATH = false;
    console.log(3);
} //실행안됨

if (typeof BUCKET_URL == 'undefined') {
    var BUCKET_URL = location.protocol + '//' + location.hostname;
    console.log(4);
} //실행안됨

if (typeof BUCKET_NAME != 'undefined') {
    // if bucket_url does not start with bucket_name,
    // assume path-style url
    if (!~BUCKET_URL.indexOf(location.protocol + '//' + BUCKET_NAME)) {
        BUCKET_URL += '/' + BUCKET_NAME;
        console.log(5);
    }
} //실행안됨

if (typeof BUCKET_WEBSITE_URL == 'undefined') {
    var BUCKET_WEBSITE_URL = BUCKET_URL;
    console.log(6);
    console.log("BUCKET_WEBSITE_URL : " + BUCKET_WEBSITE_URL);
} //실행됨

if (typeof S3B_ROOT_DIR == 'undefined') {
    var S3B_ROOT_DIR = '';
    console.log(7);
    console.log("S3B_ROOT_DIR : " + S3B_ROOT_DIR);
} //실행됨

if (typeof S3B_SORT == 'undefined') {
    var S3B_SORT = 'DEFAULT';
    console.log(8);
} //실행안됨

if (typeof EXCLUDE_FILE == 'undefined') {
    var EXCLUDE_FILE = [];
    console.log(9);
} //실행안됨
else if (typeof EXCLUDE_FILE == 'string') {
    var EXCLUDE_FILE = [EXCLUDE_FILE];
    console.log(10);
    console.log("EXCLUDE_FILE : " + EXCLUDE_FILE);
} //실행됨

// https://tc39.github.io/ecma262/#sec-array.prototype.includes
if (!Array.prototype.includes) {
    Object.defineProperty(Array.prototype, 'includes', {
        value: function (searchElement, fromIndex) {

            if (this == null) {
                throw new TypeError('"this" is null or not defined');
            }

            // 1. Let O be ? ToObject(this value).
            var o = Object(this);

            // 2. Let len be ? ToLength(? Get(O, "length")).
            var len = o.length >>> 0;

            // 3. If len is 0, return false.
            if (len === 0) {
                return false;
            }

            // 4. Let n be ? ToInteger(fromIndex).
            //    (If fromIndex is undefined, this step produces the value 0.)
            var n = fromIndex | 0;

            // 5. If n ≥ 0, then
            //  a. Let k be n.
            // 6. Else n < 0,
            //  a. Let k be len + n.
            //  b. If k < 0, let k be 0.
            var k = Math.max(n >= 0 ? n : len - Math.abs(n), 0);

            function sameValueZero(x, y) {
                return x === y || (typeof x === 'number' && typeof y === 'number' && isNaN(x) && isNaN(y));
            }

            // 7. Repeat, while k < len
            while (k < len) {
                // a. Let elementK be the result of ? Get(O, ! ToString(k)).
                // b. If SameValueZero(searchElement, elementK) is true, return true.
                if (sameValueZero(o[k], searchElement)) {
                    return true;
                }
                // c. Increase k by 1.
                k++;
            }

            // 8. Return false
            return false;
        }
    });
}

jQuery(function ($) {
    getS3Data();
});

// This will sort your file listing by most recently modified.
// Flip the comparator to '>' if you want oldest files first.
function sortFunction(a, b) {
    switch (S3B_SORT) {
        case "OLD2NEW":
            return a.LastModified > b.LastModified ? 1 : -1;
        case "NEW2OLD":
            return a.LastModified < b.LastModified ? 1 : -1;
        case "A2Z":
            return a.Key < b.Key ? 1 : -1;
        case "Z2A":
            return a.Key > b.Key ? 1 : -1;
        case "BIG2SMALL":
            return a.Size < b.Size ? 1 : -1;
        case "SMALL2BIG":
            return a.Size > b.Size ? 1 : -1;
    }
}

function getS3Data(marker, html) {
    var s3_rest_url = createS3QueryUrl(marker);
    // set loading notice
    $('#listing')
        .html('<img src="//assets.okfn.org/images/icons/ajaxload-circle.gif" />');
    $.get(s3_rest_url)
        .done(function (data) {
            // clear loading notice
            $('#listing').html('');
            var xml = $(data);
            var info = getInfoFromS3Data(xml);

            // Slight modification by FuzzBall03
            // This will sort your file listing based on var S3B_SORT
            // See url for example:
            // http://esp-link.s3-website-us-east-1.amazonaws.com/
            if (S3B_SORT != 'DEFAULT') {
                var sortedFiles = info.files;
                sortedFiles.sort(sortFunction);
                info.files = sortedFiles;
                console.log(11);
            } //실행안됨

            buildNavigation(info);

            html = typeof html !== 'undefined' ? html + prepareTable(info) : //파일이 없을 때
                prepareTable(info);
            if (info.nextMarker != "null") {
                getS3Data(info.nextMarker, html);
                console.log(12);
            } //실행안됨
            else {
                document.getElementById('listing').innerHTML =
                    '<pre>' + html + '</pre>';
                console.log(13);
            } //실행됨
        })
        .fail(function (error) {
            console.error(error);
            $('#listing').html('<strong>Error: ' + error + '</strong>');
        });
}

function buildNavigation(info) { // 맨 위에 있는 헤드부분
    var root = '<a href="?prefix=">' + BUCKET_WEBSITE_URL + '</a>/'; // 네비게이션 폴더 사이사이의 /
    if (info.prefix) {
        var processedPathSegments = '';
        var content = $.map(info.prefix.split('/'), function (pathSegment) {
            processedPathSegments = processedPathSegments + encodeURIComponent(pathSegment) + '/';
            return '<a href="?prefix=' + processedPathSegments + '">' + pathSegment + '</a>';
        });
        console.log(14);
        console.log("content : " + content);
        $('#navigation').html(root + content.join('/')); // 네비게이션 폴더 URL 사이 /
    } //실행됨
    else {
        $('#navigation').html(root);
        console.log(15);
    } //실행안됨
}

function createS3QueryUrl(marker) {
    var s3_rest_url = BUCKET_URL;
    s3_rest_url += '?delimiter=/';

    //
    // Handling paths and prefixes:
    //
    // 1. S3BL_IGNORE_PATH = false
    // Uses the pathname
    // {bucket}/{path} => prefix = {path}
    //
    // 2. S3BL_IGNORE_PATH = true
    // Uses ?prefix={prefix}
    //
    // Why both? Because we want classic directory style listing in normal
    // buckets but also allow deploying to non-buckets
    //

    var rx = '.*[?&]prefix=' + S3B_ROOT_DIR + '([^&]+)(&.*)?$';
    var prefix = '';
    if (S3BL_IGNORE_PATH == false) {
        var prefix = location.pathname.replace(/^\//, S3B_ROOT_DIR);
        console.log(16);
    } //실행안됨

    var match = location.search.match(rx);
    if (match) {
        prefix = S3B_ROOT_DIR + match[1];
        console.log(17);
        console.log("prefix : " + prefix);
    } //실행됨
    else {
        if (S3BL_IGNORE_PATH) {
            var prefix = S3B_ROOT_DIR;
            console.log(18);
            console.log("prefix : " + prefix);
        }
    }
    if (prefix) {
        // make sure we end in /
        var prefix = prefix.replace(/\/$/, '') + '/';
        s3_rest_url += '&prefix=' + prefix;
    }
    if (marker) {
        s3_rest_url += '&marker=' + marker;
    }
    return s3_rest_url;
}

function getInfoFromS3Data(xml) {
    var files = $.map(xml.find('Contents'), function (item) {
        item = $(item);
        // clang-format off
        return {
            Key: item.find('Key').text(),
            LastModified: item.find('LastModified').text(),
            Size: bytesToHumanReadable(item.find('Size').text()),
            Type: 'file'
        }
        // clang-format on
    });
    var directories = $.map(xml.find('CommonPrefixes'), function (item) {
        item = $(item);
        // clang-format off
        return {
            Key: item.find('Prefix').text(),
            LastModified: '',
            Size: '0',
            Type: 'directory'
        }
        // clang-format on
    });
    if ($(xml.find('IsTruncated')[0]).text() == 'true') {
        var nextMarker = $(xml.find('NextMarker')[0]).text();
    } else {
        var nextMarker = null;
    }
    // clang-format off
    return {
        files: files,
        directories: directories,
        prefix: $(xml.find('Prefix')[0]).text(),
        nextMarker: encodeURIComponent(nextMarker)
    }
    // clang-format on
}

// info is object like:
// {
//    files: ..
//    directories: ..
//    prefix: ...
// }
function prepareTable(info) {
    var files = info.directories.concat(info.files),
        prefix = info.prefix;
    var cols = [45, 30, 15];
    var content = [];
    // content.push(padRight('Last Modified', cols[1]) + '  ' + // 네비게이션 이름 마지막 수정 시간
    //     padRight('Size', cols[2]) + 'Key \n');
    // content.push(new Array(cols[0] + cols[1] + cols[2] + 4).join('-') + '\n');

    // add ../ at the start of the dir listing, unless we are already at root dir
    if (prefix && prefix !== S3B_ROOT_DIR) {
        var up = prefix.replace(/\/$/, '').split('/').slice(0, -1).concat('').join(
                '/'), // one directory up
            item = { // 폴더에 대한 정보
                Key: up, // 상위 디렉토리로 이동(행동)
                LastModified: '', // 마지막 수정 폴더는 없으니 ''로 통일
                Size: '', // 폴더 크기 접근 불가능 ''로 통일
                keyText: '../', // 상위 폴더로 이동(텍스트)
                href: S3BL_IGNORE_PATH ? '?prefix=' + up : '../'
            },
            row = renderRow(item, cols);
        content.push(row + '\n');
    }

    jQuery.each(files, function (idx, item) {
        // strip off the prefix
        item.keyText = item.Key.substring(prefix.length);
        if (item.Type === 'directory') {
            if (S3BL_IGNORE_PATH) {
                item.href = location.protocol + '//' + location.hostname +
                    location.pathname + '?prefix=' + item.Key;
            } else {
                item.href = item.keyText;
            }
        } else {
            item.href = BUCKET_WEBSITE_URL + '/' + encodeURIComponent(item.Key);
            item.href = item.href.replace(/%2F/g, '/');
        }
        var row = renderRow(item, cols);
        if (!EXCLUDE_FILE.includes(item.Key))
            content.push(row + '\n');
    });

    return content.join('');
}


var file_id = 0;

function renderRow(item, cols) { //누를 시 aws s3 소스 접근
    var row = '';
    var ori_text = '';
    var chng_text = '';
    // row += padRight(item.LastModified, cols[1]) + '  '; // 수정된 시간
    // row += padRight(item.Size, cols[2]); // 파일 크기
    // row += '<a href="' + item.href + '">' + item.keyText + '</a>';
    ori_text = item.keyText;
    if (item.keyText.length >= 14) {
        chng_text = item.keyText.substr(0, 14) + "...";
        row += "<div class='obj'><img src=" + "'" + item.href + "'" + " id='file_id" + file_id + "' class='obj_thumb' onError='height=0' draggable='true' ondragstart='drag(event);'><span class='obj_name' title='" + ori_text + "'>" + chng_text + "</span></div>";
        file_id++;
        return row;
    } else {
        // row += "<div class='obj'><a href=" + item.href + " ><span class='obj_thum' style='background-image: url(\"https://cdn.icon-icons.com/icons2/1128/PNG/512/1486164755-125_79693.png\");background-size: 150px 150px;'></span><span class='obj_name'>"+ori_text+"</span></a></div>";
        // console.log(item.href);
        row += "<div class='obj'><a href='#' class='openView' url=" + item.href + "><span class='obj_thum' style='background-image: url(\"/image/folder_icon.png\");background-size: 150px 150px;'></span><span class='obj_name'>" + ori_text + "</span></a></div>";
        return row;
    }
}

function padRight(padString, length) {
    var str = padString.slice(0, length - 3);
    if (padString.length > str.length) {
        str += '...';
    }
    while (str.length < length) {
        str = str + ' ';
    }
    return str;
}

function bytesToHumanReadable(sizeInBytes) {
    var i = -1;
    var units = [' kB', ' MB', ' GB'];
    do {
        sizeInBytes = sizeInBytes / 1024;
        i++;
    } while (sizeInBytes > 1024);
    return Math.max(sizeInBytes, 0.1).toFixed(1) + units[i];
}




$(".textarea").each(function () {
    var text = $(".textarea").html();
    $("#result").html(text);
    $("#result").html($("#result").html().replace(/[\|｜](.+?)《(.+?)》/g, "<ruby>$1<rt>$2</rt></ruby>")
        .replace(/[\|｜](.+?)（(.+?)）/g, "<ruby>$1<rt>$2</rt></ruby>").replace(/[\|｜](.+?)\((.+?)\)/g, "<ruby>$1<rt>$2</rt></ruby>")
        .replace(/([一-龠]+)《(.+?)》/g, "<ruby>$1<rt>$2</rt></ruby>").replace(/([一-龠]+)（([ぁ-んァ-ヶ]+?)）/g, "<ruby>$1<rt>$2</rt></ruby>")
        .replace(/([一-龠]+)\(([ぁ-んァ-ヶ]+?)\)/g, "<ruby>$1<rt>$2</rt></ruby>").replace(/[\|｜]《(.+?)》/g, "《$1》").replace(/[\|｜]（(.+?)）/g, "（$1）").replace(/[\|｜]\((.+?)\)/g, "($1)")
    );
});
