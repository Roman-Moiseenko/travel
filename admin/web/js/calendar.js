$(document).ready(function () {
    var tour_id = $('#number-tour').val();
//Переводим
    $.fn.datepicker.dates['ru'] = {
        closeText: "Закрыть",
        prevText: "Пред",
        nextText: "След ",
        days: ['воскресенье', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота'],
        daysShort: ['вск', 'пнд', 'втр', 'срд', 'чтв', 'птн', 'сбт'],
        daysMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
        months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
        monthsShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
        today: "Сегодня",
        clear: "Очистить",
        format: "mm/dd/yyyy",
        weekHeader: "Нед",
        titleFormat: "MM yyyy",
        weekStart: 0
    };

    $.post('/tours/finance/getcalendar', {tour_id: tour_id}, function (data) {
        console.log(data);
        var full_array_tours = JSON.parse(data);
        console.log(full_array_tours);
        $(function () {
            $("#datepicker").datepicker({
                format: 'mm/dd/yyyy',
                startDate: '+1d',
                language: "ru",
            });
        });

        $('#datepicker').datepicker({
            startDate: '+1d',
            language: 'ru',
            beforeShowDay: function (date) {
                console.log(full_array_tours);
                var tours = full_array_tours[date.getFullYear()]; //Массив по текущему году
                if (tours === undefined) return {enabled: true};
                tours = tours[date.getMonth() + 1];
                if (tours === undefined) return {enabled: true}; //Массив по текущему месяцу
                tours = tours[date.getDate()];
                if (tours === undefined) return {enabled: true}; //Объект по текущему дню
                var dateSel = $("#datepicker").datepicker("getDate"); //Выбранная ячейка
                var content = date.getDate() + '<div style="font-size: small;">' + tours.count + ' туров' + '</div>';
                if (dateSel !== null && dateSel.getDate() === date.getDate()) {
                    return {enabled: true, classes: 'tour-day-select', tooltip: '', content: content};
                }
                return {enabled: true, classes: 'tour-day', tooltip: '', content: content};
            }
        });
        $('#datepicker').datepicker().on('changeDate', function (e) {

            console.log(e);
            $.post('/tours/finance/getday',
                {year: e.date.getFullYear(), month: e.date.getMonth() + 1, day: e.date.getDate(), tour_id: tour_id},
                function (data) {
                    var dateInfo = JSON.parse(data);
                    $('.list-tours').html(dateInfo._list);
                    $('.new-tours').html(dateInfo._new);
                });
        });
    });


});

$(document).on('click', '.del-day', function () {
    var tour_id = $('#number-tour').val();
    var d = $('#data-day').attr('data-d');
    var m = $('#data-day').attr('data-m');
    var y = $('#data-day').attr('data-y');
    var calendar_id = $(this).attr('data-id');
    $.post('/tours/finance/delday',
        {year: y, month: m, day: d, tour_id: tour_id,
            calendar_id: calendar_id},
        function (data) {
            var dateInfo = JSON.parse(data);
            $('.list-tours').html(dateInfo._list);
            $('.new-tours').html(dateInfo._new);
        });
});

$(document).on('click', '#send-new-tour', function () {
    var tour_id = $('#number-tour').val();

    var d = $('#data-day').attr('data-d');
    var m = $('#data-day').attr('data-m');
    var y = $('#data-day').attr('data-y');
    var _time = $('#_time').attr('value');
    var _tickets = $('#_tickets').val();
    var _adult = $('#_adult').val();
    var _child = $('#_child').val();
    var _preference = $('#_preference').val();

    $.post('/tours/finance/setday',
        {year: y, month: m, day: d, tour_id: tour_id,
            _time: _time, _tickets: _tickets, _adult: _adult, _child: _child, _preference: _preference},
        function (data) {
            var dateInfo = JSON.parse(data);
            $('.list-tours').html(dateInfo._list);
            $('.new-tours').html(dateInfo._new);
        });
});