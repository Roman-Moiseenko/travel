$(document).ready(function () {
    const COMMENT_TAG = 'comment';
    if (document.getElementById(COMMENT_TAG)) {

        let user = localStorage.getItem('user');
        //Получаем пользователя в сессии
        $.post('/comment/new-comment/', {user: user}, function (data) {
            $('#' + COMMENT_TAG).html(data)
        });

        //if нет пользователя,
    }
});