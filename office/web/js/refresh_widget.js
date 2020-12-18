$(document).ready(function() {

    let timerId = setInterval( function () {
        
        $.post('/refresh/active', {}, function (data) {
            $("#active-widget").html(data);
        });

        $.post('/refresh/message', {}, function (data) {
            $("#message-widget").html(data);
        });
        
    }, 5000);

});