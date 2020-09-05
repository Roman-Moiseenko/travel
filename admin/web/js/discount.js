$(document).ready(function() {

    $('body').on('change', '#discount-entities', function () {
        let value = $(this).val();
        $.post("/discount/load", {set: value}, function (data) {
            $("#discount-entities-id").html(data);
            });
    });

});