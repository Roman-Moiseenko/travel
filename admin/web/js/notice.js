$(document).ready(function() {
    var baseUrl ='/admin';
    $('body').on('click', '.notice-ajax', function () {
        let item = $(this).attr('data-item');
        let field = $(this).attr('data-field');
        let value = 0;
        if ($(this).is(':checked')) {value = 1;} else {value = 0;}
        $.post(baseUrl + "/cabinet/notice/ajax",
            {item: item, field: field, set: value},
            function (data) {
            });
    });

});