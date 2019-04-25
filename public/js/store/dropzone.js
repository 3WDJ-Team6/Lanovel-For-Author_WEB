Dropzone.options.dropzone = {
    addRemoveLinks: true,
    dictRemoveFile: "remove",
    paramName: "image",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function (file, response) {
        console.log(file);
        console.log(response); //controller에서 response 메서드로 보낸 데이터가 들어있음
        // console.log([
        //   file.name,
        //   file.size,
        // ]);
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
