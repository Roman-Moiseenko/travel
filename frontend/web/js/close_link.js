$(document).ready(function () {

    if (document.getElementById("close-link")) {
        let link = $('#close-link').data('link');
        console.log(link);
        $.post('/moving/close/get-link', {link: link}, function (data) {
            $('#close-link').html(data);
        });
    }

});