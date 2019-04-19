// // 파일추가
// $(function () {
//     $("#upload_file").on('change', function () {

//         readURL(this);
//     });
// });

// // 사진
// function readURL(input) {
//     if (input.files && input.files[0]) {
//         var reader = new FileReader();

//         reader.onload = function (e) {
//             $('#blah').attr('src', e.target.result);
//         }
//         reader.readAsDataURL(input.files[0]);
//     }
// }

function showPreview(objFileInput) {
    if (objFileInput.files[0]) {
        var fileReader = new FileReader();
        fileReader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
            $("#targetLayer").html('<img src="' + e.target.result + '" width="200px" height="200px" class="upload-preview" />');
            $("#targetLayer").css('opacity', '0.7');
            $(".icon-choose-image").css('opacity', '0.5');
        }
        fileReader.readAsDataURL(objFileInput.files[0]);
    }
}

$(document).ready(function (e) {
    $("#uploadForm").on('submit', (function (e) {
        e.preventDefault();
        $.ajax({
            url: "book_add.blade.php",
            type: "POST",
            data: new FormData(this),
            beforeSend: function () {
                $("#body-overlay").show();
            },
            contentType: false,
            processData: false,
            success: function (data) {
                $("#targetLayer").html(data);
                $("#targetLayer").css('opacity', '1');
                setInterval(function () {
                    $("#body-overlay").hide();
                }, 500);
            },
            error: function () {}
        });
    }));
});
