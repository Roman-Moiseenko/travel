$(document).ready(function() {
    var baseUrl ='/admin';
    $('body').on('input', '#toursparamsform-duration', function () {
        let value = $(this).val();
        if (value == 1) {
            $('#toursparamsform-groupmin').val('1');
            $('#toursparamsform-groupmin').attr('disabled', true);
        } else {
            $('#toursparamsform-groupmin').val('');
            $('#toursparamsform-groupmin').attr('disabled', false);
        }
    });
    $('body').on('change', '#agelimitform-on', function () {

        if ($(this).is(':checked')) {
            $('#agelimitform-agemin').val('');
            $('#agelimitform-agemax').val('');
            $('.agelimit-edit').show();

        } else {

            $('.agelimit-edit').hide();
        }
    });

    $('body').on('click', '.extra-check', function () {
        let tours_id = $(this).attr('tours-id');
        let extra_id = $(this).attr('extra-id');
        let value = 0;
         if ($(this).is(':checked')) {value = 1;} else {value = 0;}
        $.post(baseUrl + "/tour/extra/setextra?tours_id="+tours_id+"&extra_id="+extra_id+"&set="+value,
            {tours_id: tours_id, extra_id: extra_id, set: value},
            function (data) {
        });
    });

    $('body').on('click', '.collapse-time', function () {
        let status = $(this).attr('data-status');
        let id = $(this).attr('aria-controls');
        if (status === 'down') {
            $(this).attr('data-status', 'up');
            $(this).html('<i class="fas fa-chevron-up""></i>');
            if (!$('#' + id).hasClass('show')) {$('#' + id).collapse('show');}
        }
        if (status === 'up') {
            $(this).attr('data-status', 'down');
            $(this).html('<i class="fas fa-chevron-down""></i>');
            if ($('#' + id).hasClass('show')) {$('#' + id).collapse('hide');}
        }
    });

});