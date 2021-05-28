$(document).ready(function () {

    if (document.getElementById("close-link")) {
        let link = $(this).data('link');

        $.post('/moving/close-link/get', {link: link}, function (data) {
            $(this).html(data);
        });
    }

});