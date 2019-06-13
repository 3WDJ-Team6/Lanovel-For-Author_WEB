$(document).ready(function () {

    var clone_el = null;

    $(".sidebar-item").draggable({
        helper: 'clone',
        cursor: 'move',
        tolerance: 'fit'
    });

    $("#drop_canvas").droppable({

        drop: function (e, ui) {

            if ($(ui.draggable)[0].id != "") {
                clone_el = ui.helper.clone();
                ui.helper.remove();
                clone_el.draggable({
                    helper: 'original',
                    containment: '#drop_canvas',
                    tolerance: 'fit'
                });

                clone_el.appendTo('#drop_canvas');
            }

        }
    });

});
