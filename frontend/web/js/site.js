$(document).ready(function() {

    $('body').on('click', '.ltttttt', function () {
        let lang = $(this).attr('data-value');
        $.post("/user/lang?lang="+lang, {lang: lang, }, function (data) {
            $('#lang-top').html(data);
        });
    });

    $('body').on('input', '.only-numeric', function () {
        var vl = $(this).val().replace(/\D/g, ''); //str.replace(/[^a-zA-Z ]/g, "")
        $(this).val(vl);
        $(this).change();
    });

})(window.jQuery);