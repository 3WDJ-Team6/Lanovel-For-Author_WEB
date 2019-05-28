$(document).ready(function () {

    var clone = null;

    $(".sidebar-item").draggable({
        helper: 'clone',
        cursor: 'move',
        tolerance: 'fit'
    });

    $("#drop_canvas").droppable({

        drop: function (e, ui) {

            if ($(ui.draggable)[0].id != "") {
                clone = ui.helper.clone();
                ui.helper.remove();
                clone.draggable({
                    helper: 'original',
                    containment: '#drop_canvas',
                    tolerance: 'fit'
                });
                clone.appendTo('#drop_canvas');
            }

        }
    });

});
