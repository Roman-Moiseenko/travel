$(document).ready(function() {
    var baseUrl ='/admin';
    $('body').on('change', '#discount-entities', function () {
        let value = $(this).val();
        $.post(baseUrl + "/discount/load", {set: value}, function (data) {
            $("#discount-entities-id").html(data);
            });
    });

});