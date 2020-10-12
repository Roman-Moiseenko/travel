$(document).ready(function () {
    var tour_id = $('#number-tour').val(); //Текущий тур
    var full_array_tours; //Массив туров по дням
//Переводим
    if ($.fn.datepicker === undefined) return false;
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
        weekStart: 1
    };
    //Устанавливаем datepicker
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
            if (full_array_tours === undefined) return {enabled: true};
            var tours = full_array_tours[date.getFullYear()]; //Массив по текущему году
            if (tours === undefined) return {enabled: true};
            tours = tours[date.getMonth() + 1];
            if (tours === undefined) return {enabled: true}; //Массив по текущему месяцу
            tours = tours[date.getDate()];
            if (tours === undefined) return {enabled: true}; //Объект по текущему дню
            var dateSel = $("#datepicker").datepicker("getDate"); //Выбранная ячейка
            var content = date.getDate() + '<div style="font-size: small;">' + tours.count + ' туров' + '</div>';
            if (dateSel !== null && dateSel.getDate() === date.getDate()) { //Совпала с текущим днем
                return {enabled: true, classes: 'tour-day-select', tooltip: '', content: content};
            }
            //console.log(new Date().getDate());
           // console.log(date.getDate());
            /*if (new Date().getDate() === date.getDate()) {
                return {enabled: false, classes: 'tour-day-deselect', tooltip: '', content: content};
            } */
            return {enabled: true, classes: 'tour-day', tooltip: '', content: content};
        }
    });
    //Событие при выборе даты
    $('#datepicker').datepicker().on('changeDate', function (e) {
      //  console.log(e);
        if ($('#data-day-copy').is(':checked')) {
            //Установлен флажок Копировать
            var d = $('#data-day').attr('data-d');
            var m = $('#data-day').attr('data-m');
            var y = $('#data-day').attr('data-y');

            $.post('/tour/calendar/copyday',
                {
                    year: e.date.getFullYear(),
                    month: e.date.getMonth() + 1,
                    day: e.date.getDate(),
                    tour_id: tour_id,
                    copy_year: y,
                    copy_month: m,
                    copy_day: d
                },
                function (data) {
                    full_array_tours = JSON.parse(data);
                    $('#datepicker').datepicker('update');
                });
        } else {
            //Иначе получаем сведения о тек.дне
            $.post('/tour/calendar/getday',
                {year: e.date.getFullYear(), month: e.date.getMonth() + 1, day: e.date.getDate(), tour_id: tour_id},
                function (data) {
                    var dateInfo = JSON.parse(data);
                    $('.list-tours').html(dateInfo._list);
                    $('.new-tours').html(dateInfo._new);
                });
        }
    });
    //Событие при выборе месяца
    $('#datepicker').datepicker().on('changeMonth', function (e) {

        $.post('/tour/calendar/getcalendar',
            {tour_id: tour_id, month: e.date.getMonth() + 1, year: e.date.getFullYear()}, function (data) {
                full_array_tours = JSON.parse(data);
                $('#datepicker').datepicker('setDate', new Date(e.date.getFullYear() + '/' + (e.date.getMonth() + 1) + '/01'));
                $('#datepicker').datepicker('update');
                if (!$('#data-day-copy').is(':checked')) {
                    $('.list-tours').html();
                    $('.new-tours').html();
                }
            });
    });
    //Загружаем Массив туров по дням за текущий день
    $.post('/tour/calendar/getcalendar', {tour_id: tour_id, current_month: true}, function (data) {
        full_array_tours = JSON.parse(data);
        $('#datepicker').datepicker('update');
    });

    $(document).on('click', '#send-new-tour', function () {
        var d = $('#data-day').attr('data-d');
        var m = $('#data-day').attr('data-m');
        var y = $('#data-day').attr('data-y');
        var _time = $('#_time').val();
        var _tickets = $('#_tickets').val();
        var _adult = $('#_adult').val();
        var _child = $('#_child').val();
        var _preference = $('#_preference').val();
        if (_child === undefined) {
            _child = null;
        }
        if (_preference === undefined) {
            _preference = null;
        }

        $.post('/tour/calendar/setday',
            {
                year: y, month: m, day: d, tour_id: tour_id,
                _time: _time, _tickets: _tickets, _adult: _adult, _child: _child, _preference: _preference
            },
            function (data) {
                var dateInfo = JSON.parse(data);
                $('.list-tours').html(dateInfo._list);
                $('.new-tours').html(dateInfo._new);
                full_array_tours = dateInfo.full_array_tours;
               //console.log(dateInfo._new);
                // console.log(full_array_tours);
                $('#datepicker').datepicker('update'); //, new Date(y + '/' + m + '/' + d)
            });
    });

    $(document).on('click', '.del-day', function () {
        var d = $('#data-day').attr('data-d');
        var m = $('#data-day').attr('data-m');
        var y = $('#data-day').attr('data-y');
        var calendar_id = $(this).attr('data-id');
        $.post('/tour/calendar/delday',
            {
                year: y, month: m, day: d, tour_id: tour_id,
                calendar_id: calendar_id
            },
            function (data) {
                var dateInfo = JSON.parse(data);
                $('.list-tours').html(dateInfo._list);
                $('.new-tours').html(dateInfo._new);
                //console.log(dateInfo._new);
                full_array_tours = dateInfo.full_array_tours;
             //   console.log(full_array_tours);
                $('#datepicker').datepicker('update'); //, new Date(y + '/' + m + '/' + d)
            });
    });

    $(document).on('click', '#data-day-copy', function () {
        if ($('#data-day-copy').is(':checked')) {
            $('.new-tours').addClass('hidden');
            $('#data-week-copy').prop("disabled", true);
        } else {
            $('.new-tours').removeClass('hidden');
            $('#data-week-copy').prop("disabled", false);
        }
    });
    $(document).on('click', '#data-week-copy', function () {
        var d = $('#data-day').attr('data-d');
        var m = $('#data-day').attr('data-m');
        var y = $('#data-day').attr('data-y');
        let week = [];
        week[0] = $('#end-day').val();
        for (let i = 1; i <= 7; i++) {
            week[i] = $('#data-week-' + i).is(':checked');
        }
        $.post('/tour/calendar/copyweek', {year: y, month: m, day: d, tour_id: tour_id, json: JSON.stringify(week)},
            function (data) {
            //console.log(data);
                full_array_tours = JSON.parse(data);
                $('#datepicker').datepicker('update');
                //Очищаем чекбоксы
                for (let i = 1; i <= 7; i++) {
                    $('#data-week-' + i).prop('checked', false);
                }
            });
    });

});



