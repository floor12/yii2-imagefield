/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var curObj;
var cropper;
var currentCropId
var modal;

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
            curObj.removeClass('myhidden');
        }
    });
}

$(document).ready(function () {

    modal = $('#editorModal');

    setInterval(function () {
        draggble();
    }, 3000);

    var uploader = new ss.SimpleUpload({
        button: '#image-field-add', // HTML element used as upload button
        url: '/imagefield/create/', // URL of server-side upload handler
        name: 'image[]',
        noParams: true,
        multiple: true,
        maxUploads: 10,
        multipart: true,
        data: {'_csrf': csrfToken, class: className},
        onSubmit: function (filename, extension) {
            $('#process').show();
            this.setProgressBar($('#progressBar')); // designate as progress bar
        },
        onComplete: function (filename, response) {
            $('#process').hide();
            if (!response) {
                alert(filename + 'upload failed');
                return false;
            }
            $(response).appendTo('#imagefield-images').fadeIn(500);
        }
    });


//    $('#image-field-add').uploaderZ({
//        'action': '/imagefield/create/',
//        'fieldName': 'image[]',
//        'csrfParam': csrfParam,
//        'csrfToken': csrfToken,
//        'data': {'class': className},
//        'complite': function (msg) {
//            if (msg != '0') {
//                $(msg).appendTo('#imagefield-images').fadeIn(500);
//            }
//        }
//    });

    //$(function () {
    //    $('#fileupload').fileupload({
    //        dataType: 'json',
    //        done: function (e, data) {
    //            $.each(data.result.files, function (index, file) {
    //                $('<p/>').text(file.name).appendTo(document.body);
    //            });
    //        }
    //    });
    //});
    //




    $(document).on('mouseover', '.imagefield-image', function () {
        $(this).find('.imagefield-control').stop().fadeIn(200);
    })
    $(document).on('mouseout', '.imagefield-image', function () {
        $(this).find('.imagefield-control').stop().fadeOut(200);
    })

    $(document).on('mouseover', '.imagefield-control', function () {
        $(this).stop().fadeIn(200);
    })
    $(document).on('mouseout', '.imagefield-control', function () {
        $(this).stop().fadeOut(200);
    })


    $(document).on('click', '.imagefield-delete', function () {
        var obj = $(this);
        if (confirm("Удалить изображение?"))
            $.ajax({
                method: "post",
                url: '/imagefield/delete/',
                data: 'id=' + obj.attr('data-id'),
                success: function (msg) {
                    if (msg = '1') {
                        obj.parent().parent().fadeOut(500, function () {
                            $(this).remove();
                        });
                    }
                }
            })

    })

    $(document).on('click', '.imagefield-crop', function () {
        var obj = $(this);
        currentCropId = obj.attr('data-id');
        src = obj.parent().parent().find('img').attr('src');
        var image = $('<img>').attr('src', src);
        $('#imagefield-editor-aria').html(image);
        modal.modal('show');
        cropper = image.cropper({
            viewMode: 1,
            minContainerWidth: 870,
            minContainerHeight: 500,
        });

        $('#imagefield-control-01').click(function () {
            cropper.cropper('setAspectRatio', 1 / 1);
        });
        $('#imagefield-control-02').click(function () {
            cropper.cropper('setAspectRatio', 3 / 4);
        });

        $('#imagefield-control-03').click(function () {
            cropper.cropper('setAspectRatio', 4 / 3);
        });

        $('#imagefield-control-04').click(function () {
            cropper.cropper('setAspectRatio', 16 / 9);
        });
    })

});


function imagefieldCrop(createNew) {
    сropBoxData = cropper.cropper('getCropBoxData');
    imageData = cropper.cropper('getImageData');
    canvasData = cropper.cropper('getCanvasData');
    ratio = imageData.height / imageData.naturalHeight;
    cropLeft = (сropBoxData.left - canvasData.left) / ratio;
    cropTop = (сropBoxData.top - canvasData.top) / ratio;
    cropWidth = сropBoxData.width / ratio;
    cropHeight = сropBoxData.height / ratio;
    data = {
        id: currentCropId,
        width: cropWidth,
        height: cropHeight,
        top: cropTop,
        left: cropLeft,
        createNew: createNew
    }
    $.ajax({
        method: "post",
        url: '/imagefield/crop/',
        data: data,
        success: function (msg) {
            if (createNew) {
                obj = $(msg);
                $('#imagefield-images').append(obj);
                if (obj.hasClass('myhidden'))
                    obj.fadeIn(300);
            } else {
                $('#imagefield_' + currentCropId).replaceWith(msg);

            }




            modal.modal('hide');
        }
    })




}

