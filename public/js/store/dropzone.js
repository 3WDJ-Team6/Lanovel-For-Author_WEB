Dropzone.options.dropzone = {
    addRemoveLinks: true,
    dictRemoveFile: "remove",
    paramName: "image",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    removedfile: function (file) {
        var fileid = file.upload.id;
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'DELETE',
            url: '/fileDelete/' + fileid,
            success: function (image) {
                console.log(image);
                alert('삭제성공');
            },
            error: function (e) {
                console.log(e);
                throw new Error('서버오류');
            }
        });
        var fileRef;
        return (fileRef = file.previewElement) != null ?
            fileRef.parentNode.removeChild(file.previewElement) : void 0;
    },
    success: function (file, response) {
        console.log(file);
        console.log(response); //controller에서 response 메서드로 보낸 데이터가 들어있음
        file.upload.id = response.id;
        $("<input>", {
            type: 'hidden',
            name: 'attachments[]',
            value: response.id
        }).appendTo($('#store'));
    },
    error: function (file, response) {
        throw new Error('x');
    }
}
