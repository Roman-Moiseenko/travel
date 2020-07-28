$(document).ready(function() {

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

})(window.jQuery);