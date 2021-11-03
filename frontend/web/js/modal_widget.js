$(document).ready(function () {

    if (document.getElementById("modal_widget")) {

        let isDisplay = false;
        let link = $('#modal_widget').data('link');


            $(window).scroll(function () {
                if ($(window).scrollTop() == $(document).height() - $(window).height() ) {
                    //Пользователь долистал до низа страницы
                    //if (isDisplay == false)
                    $.post('/moving/moving/modal', {modal_id: "moving_anketa", function(data) {
                            $('#modal_widget').html('');
                        }});
                    isDisplay = true;
                }
            });
        }


});