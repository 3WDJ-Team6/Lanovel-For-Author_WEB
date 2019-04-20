$(document).ready(function () {

    $("input[type=file]").change(function () {

        var fileInput = document.getElementById("contract_file");
        var files = fileInput.files;
        var file;

        for (var i = 0; i < files.length; i++) {

            file = files[i];
            document.getElementById("file.name").innerHTML = file.name;

            // alert(file.name);
        }

    });

});
