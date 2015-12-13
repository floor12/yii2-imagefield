/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var curObj;

function draggble() {
    $('div.imagefield-image').draggable({
        cursor: "move",
        opacity: 0.8,
        start: function () {
            curObj = $(this);
            curObj.css('z-index', 9999);
        },
        stop: function () {
            $(this).attr('style', '');
        },
    });

    $('div.imagefield-image').droppable({
        drop: function (event, ui) {
            curObj.insertBefore($(this));
        }
    });
}



$(document).ready(function () {

    setInterval(function () {
        draggble();
    }, 3000);

    $('#image-field-add').uploaderZ({
        'action': '/imagefield/create/',
        'fieldName': 'image[]',
        'csrfParam': csrfParam,
        'csrfToken': csrfToken,
        'data': {'class': className},
        'complite': function (msg) {
            if (msg != '0') {
                $(msg).appendTo('#imagefield-images').fadeIn(500);
            }
        }
    });


    $(document).on('click', '.imagefield-delete', function () {
        var obj = $(this);
        $.ajax({
            method: "post",
            url: '/imagefield/delete/',
            data: 'id=' + obj.attr('data-id'),
            success: function (msg) {
                if (msg = '1') {
                    obj.parent().fadeOut(500, function () {
                        $(this).remove();
                    });
                }
            }
        })
    })

});


