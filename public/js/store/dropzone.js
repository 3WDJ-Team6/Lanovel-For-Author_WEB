Dropzone.options.dropzone = {
    addRemoveLinks: true,
    dictRemoveFile: "remove",
    paramName: "image",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
<<<<<<< HEAD
=======
    },
    removedfile: function (file) {
        var fileid = file.upload.id;
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'DELETE',
            url: '/fileDelete/' + fileid,
            success: function () {
                alert('삭제성공');
            },
            error: function (e) {
                //console.log(e);
                alert(e.responseText);
            }
        });
        var fileRef;
        return (fileRef = file.previewElement) != null ?
            fileRef.parentNode.removeChild(file.previewElement) : void 0;
>>>>>>> b442f95971aa7b6925a2e235ea17416c22f3ba1f
    },
    success: function (file, response) {
        console.log(file);
        console.log(response); //controller에서 response 메서드로 보낸 데이터가 들어있음
<<<<<<< HEAD
        // console.log([
        //   file.name,
        //   file.size,
        // ]);
=======
>>>>>>> b442f95971aa7b6925a2e235ea17416c22f3ba1f
        file.upload.id = response.id;
        $("<input>", {
            type: 'hidden',
            name: 'attachments[]',
            value: response.id
        }).appendTo($('#store'));
    },
    error: function (file, response) {
<<<<<<< HEAD
        throw new Error('x');
=======
        return false;
>>>>>>> b442f95971aa7b6925a2e235ea17416c22f3ba1f
    }
}
