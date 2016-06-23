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




});


