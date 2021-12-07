$(document).ready(function () {
    if (document.getElementById("youtube_widget")) {
        let url_video = $('#youtube_widget').data('url');
        console.log('33');
        $.post('/ajax/youtube', {url_video: url_video}, function(data) {
            console.log(data);
            //$('#youtube_widget').html(data);
        });
    }
});