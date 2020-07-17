$(document).ready(function() {

    $('body').on('click', '.ltttttt', function () {
        let lang = $(this).attr('data-value');
        $.post("/user/lang?lang="+lang, {lang: lang, }, function (data) {
            $('#lang-top').html(data);
        });
    });

})(window.jQuery);