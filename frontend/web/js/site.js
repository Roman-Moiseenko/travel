$(document).ready(function () {

    $('body').on('click', '.ltttttt', function () {
        let lang = $(this).attr('data-value');
        $.post("/user/lang?lang=" + lang, {lang: lang,}, function (data) {
            $('#lang-top').html(data);
        });
    });

    $('body').on('input', '.only-numeric', function () {
        var vl = $(this).val().replace(/\D/g, ''); //str.replace(/[^a-zA-Z ]/g, "")
        $(this).val(vl);
        $(this).change();
    });


    if (document.getElementById("class_widget")) {
        let class_widget = $('#class_widget').data('class');
        $.post('/ajax/get-widget', {class_widget: class_widget}, function (data) {
            console.log(data);
            $('#class_widget').html(data);
        });
    }

    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 100) {
            if ($('#upbutton').is(':hidden')) {
                $('#upbutton').css({opacity: 1}).fadeIn('slow');
            }
        } else {
            $('#upbutton').stop(true, false).fadeOut('fast');
        }
    });
    $('#upbutton').on('click', function () {
        $('html, body').stop().animate({scrollTop: 0}, 300);
    });
});