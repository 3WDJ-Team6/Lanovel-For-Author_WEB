// 파일추가
$(function () {
    $("#upload_file").on('change', function () {

        var url = "{{asset('img/upload')}}";
        readURL(this);
    });
});

// 사진
// function readURL(input) {
//     if (input.files && input.files[0]) {
//         var reader = new FileReader();
//         reader.onload = function (e) {
//             $('#blah').attr('src', e.target.result);
//         }
//         reader.readAsDataURL(input.files[0]);
//     }
// }
