// How to use:
//
// $('#uploader').uploaderZ({    
//    'action':'/core/avatar/',
//     'data': { 'upload' : 'test'},
//     'fieldName': 'file',
//     'complite': function(msg){
//        console.log(msg);
//     }
//  });
(function ($) {
    $.fn.uploaderZ = function (options) {
        var settings = $.extend({
            'action': '',
            'data': '',
            'csrfParam': '1',
            'csrfToken': '2',
            'fieldName': 'uploads',
            'complite': function (msg) {
                alert(msg)
            }
        }, options);
        var frame, msg;
        var rand = Math.floor(Math.random() * (0 - 1000) + 1000);
        var msg = '';
        var string = "<form action='" + settings.action + "' id='uploaderForm' method='post' enctype='multipart/form-data'><input type='hidden' name='" + settings.csrfParam + "' value=" + settings.csrfToken + "' /><input type='file' multiple='multiple' name='" + settings.fieldName + "' id='uploaderInput'><input type='submit'></form>";
        $('<iframe>').attr('id', 'uploaderIframe' + rand).css('display', 'none').appendTo('body');
        var doc = $('#uploaderIframe' + rand)[0].contentDocument;
        if (!doc) // for IE
            doc = document.frames('uploaderIframe').document;
        doc.open('text/html');
        doc.write(string);
        doc.close();
        $('#uploaderIframe' + rand).ready(function () {
            frame = $('#uploaderIframe' + rand).contents();
            $.each(settings.data, function (name, val) {
                $("<input type='hidden' name='" + settings.csrfParam + "' value=" + settings.csrfToken + "' /><input type='text' name='" + name + "' value='" + val + "'>").appendTo(frame.find('#uploaderForm'));
            })
            frame.find('#uploaderInput').bind('change', function () {
                frame.find('#uploaderForm').submit()
                $('#loadingZ').show();
            })
        });
        this.bind('click', function () {
            frame.find('#uploaderInput').click()
            if ($.browser.msie) {
                frame.find('#uploaderForm').submit()
                $('#loadingZ').show();
            }
        })
        var intervalID = window.setInterval(function () {
            var frm = $('#uploaderIframe' + rand).contents().find('#uploaderForm').length;
            if (!frm) {
                msg = $('#uploaderIframe' + rand).contents().find('body').html();
                var doc = $('#uploaderIframe' + rand)[0].contentDocument;
                if (!doc) // for IE
                    doc = document.frames('uploaderIframe').document;
                doc.open('text/html');
                doc.write(string);
                doc.close();
                $('#uploaderIframe' + rand).ready(function () {
                    frame = $('#uploaderIframe' + rand).contents();
                    $("<input type='hidden' name='" + settings.csrfParam + "' value=" + settings.csrfToken + "' />").appendTo(frame.find('#uploaderForm'));
                    $.each(settings.data, function (name, val) {
                        $("<input type='text' multiple='multiple' name='" + name + "' value='" + val + "'>").appendTo(frame.find('#uploaderForm'));
                    })
                    frame.find('#uploaderInput').bind('change', function () {
                        frame.find('#uploaderForm').submit();
                        $('#loadingZ').show();
                    })
                });
                $('#loadingZ').hide();
                settings.complite(msg);

            }
        }, 1000);
    };
})(jQuery);