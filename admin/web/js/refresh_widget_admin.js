$(document).ready(function() {

    let timerId = setInterval( function () {
        
        $.post('/refresh/review', {}, function (data) {
            $("#review-widget").html(data);
        });

        $.post('/refresh/message', {}, function (data) {
            $("#message-widget").html(data);
        });

        $.post('/refresh/booking', {}, function (data) {
            $("#booking-widget").html(data);
        });
    }, 10000);

});