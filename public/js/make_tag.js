function makeTag(data){
    var tag = "";
    // if(data.length === 0){
    //     // data 값이 없을 때
    //     isLoading = false;
    //     $('.post-preview').html(tag);
    //     return;
    // }
console.log(1);

    var chapter = data;
    // chapter = !chapter.length ? [chapter] : chapter;
    
    if (chapter) {
        console.log(chapter);
        tag +=
            "<div class='post-preview'>" +
            "<a href='/editor/main/list/" + chapter.num + "'>" +
            "<h3 class='post-subtitle'>" +
            "<img src='image/book.png'" + "alt='표지1' style='width:130px; height:130px;' class='img-thumbnail'>" +
            chapter.subtitle +
            "</h3>" + 
            "</a>" + 
            "<p class='post-meta'>" + "ajax test" + "</p>" + 
            "</div>" + 
            "<hr>";
    }
    $('#chapter_box').html(tag);
}