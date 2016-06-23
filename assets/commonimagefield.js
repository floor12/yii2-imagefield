/**
 * Created by floor12 on 31.05.2016.
 */


$(document).ready(function () {

    modal = $('#editorModal');


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
        field = obj.attr('data-field');
        if (confirm("Удалить изображение?"))
            $.ajax({
                method: "post",
                url: '/imagefield/delete/',
                data: {'id': obj.attr('data-id'), field: field},
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
        currentField = obj.attr('data-field');
        src = obj.parent().parent().find('img').attr('src');
        var image = $('<img>').attr('src', src);
        $('#imagefield-editor-aria').html(image);
        $('#cropField').html('');
        $('#cropField').html(currentField);
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

})


function imagefieldCrop(createNew) {
    field = $('#cropField').html();
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
        field: field,
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
