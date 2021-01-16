$(document).ready(function() {
/*

    $('body').on('change', '#tourparamsform-private', function () {
        let value = $(this).val();
        console.log(value);
        if (value == 1) {
            console.log('1');
            $('#tourparamsform-groupmin').val('1');
            $('#tourparamsform-groupmin').attr('readonly', 'readonly');
            $('#tourparamsform-groupmin').change();
        } else {
            console.log('0');
           // $('#toursparamsform-groupmin').val('');
            $('#tourparamsform-groupmin').removeAttr('readonly');
            $('#toursparamsform-groupmin').change();
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

*/
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