$(document).ready(function () {
    if (document.getElementById("modal_widget")) {
        let isDisplay = false;
        let modal_id = $('#modal_widget').data('modal_id');
            $(window).scroll(function () {
                if ($(window).scrollTop() == $(document).height() - $(window).height() ) {
                    //Пользователь долистал до низа страницы
                    if (isDisplay == false)
                    $.post('/moving/moving/modal', {modal_id: modal_id}, function(data) {
                            $('#modal_widget').html(data);
                        });
                    isDisplay = true;
                }
            });
        }
});