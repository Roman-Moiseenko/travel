$(document).ready(function () {
    /** ver 16.11.2020 */
    let tour_id = $('#number-tour').val(); //Текущий тур
    let full_array_tours; //Массив туров по дням
    let baseUrl ='';
    let current_month = (new Date()).getMonth();
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
        $("#datepicker-tour").datepicker({
            format: 'mm/dd/yyyy',
            startDate: '+1d',
            language: "ru",
        });
    });
    $('#datepicker-tour').datepicker({
        startDate: '+1d',
        language: 'ru',
        beforeShowDay: function (date) {
            let dateSel = $("#datepicker-tour").datepicker("getDate"); //Выбранная ячейка
            if (dateSel !== null) current_month = dateSel.getMonth();
            if (full_array_tours === undefined) return {enabled: true};
            var tours = full_array_tours[date.getFullYear()]; //Массив по текущему году
            if (tours === undefined) return {enabled: true};
            tours = tours[date.getMonth() + 1];
            if (tours === undefined) return {enabled: true}; //Массив по текущему месяцу
            tours = tours[date.getDate()];
            if (tours === undefined) return {enabled: true}; //Объект по текущему дню

            var content = date.getDate() + '<div style="font-size: small;">' + tours.count + ' туров' + '</div>' +
                '<div style="font-size: small;">' + tours.tickets + ' билетов' + '</div>';
            if (dateSel !== null && dateSel.getDate() === date.getDate() && date.getMonth() === dateSel.getMonth()) { //Совпала с текущим днем
                return {enabled: true, classes: 'calendar-day-select', tooltip: '', content: content};
            }
            //if (date.getMonth() !== current_month) return {enabled: true, classes: 'calendar-day-other-month', tooltip: '', content: content};
            return {enabled: true, classes: 'calendar-day', tooltip: '', content: content};
            //
        }
    });
    //Событие при выборе даты
    $('#datepicker-tour').datepicker().on('changeDate', function (e) {
        //current_month = e.date.getMonth();
      //  console.log(e);
        if ($('#data-day-copy').is(':checked')) {
            //Установлен флажок Копировать
            let d = $('#data-day').attr('data-d');
            let m = $('#data-day').attr('data-m');
            let y = $('#data-day').attr('data-y');
            $.post(baseUrl + '/tour/calendar/copyday',
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
                    $('#datepicker-tour').datepicker('update');
                });
        } else {
            //Иначе получаем сведения о тек.дне
            if (e.date === undefined) return;
            if (e.date.getMonth() !== current_month) current_month = e.date.getMonth();
            console.log(e.date);
            $.post(baseUrl + '/tour/calendar/getday',
                {year: e.date.getFullYear(), month: e.date.getMonth() + 1, day: e.date.getDate(), tour_id: tour_id},
                function (data) {
                    let dateInfo = JSON.parse(data);
                    $('.list-tours').html(dateInfo._list);
                    $('.new-tours').html(dateInfo._new);
                });
        }
    });
    //Событие при выборе месяца
    $('#datepicker-tour').datepicker().on('changeMonth', function (e) {
        current_month = e.date.getMonth();
    });
    //Загружаем Массив туров по дням за текущий день
    if (document.getElementById('datepicker-tour')) {
        $.post(baseUrl + '/tour/calendar/getcalendar', {tour_id: tour_id, current_month: true}, function (data) {
            full_array_tours = JSON.parse(data);
            $('#datepicker-tour').datepicker('update');
        });
    }

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

        $.post(baseUrl + '/tour/calendar/setday',
            {
                year: y, month: m, day: d, tour_id: tour_id,
                _time: _time, _tickets: _tickets, _adult: _adult, _child: _child, _preference: _preference
            },
            function (data) {
                var dateInfo = JSON.parse(data);
                $('.list-tours').html(dateInfo._list);
                $('.new-tours').html(dateInfo._new);
                full_array_tours = dateInfo.full_array_tours;
                $('#datepicker-tour').datepicker('update'); //, new Date(y + '/' + m + '/' + d)
            });
    });

    $(document).on('click', '.del-day', function () {
        var d = $('#data-day').attr('data-d');
        var m = $('#data-day').attr('data-m');
        var y = $('#data-day').attr('data-y');
        var calendar_id = $(this).attr('data-id');
        $.post(baseUrl + '/tour/calendar/delday',
            {
                year: y, month: m, day: d, tour_id: tour_id,
                calendar_id: calendar_id
            },
            function (data) {
                var dateInfo = JSON.parse(data);
                $('.list-tours').html(dateInfo._list);
                $('.new-tours').html(dateInfo._new);
                full_array_tours = dateInfo.full_array_tours;
                $('#datepicker-tour').datepicker('update'); //, new Date(y + '/' + m + '/' + d)
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
        $.post(baseUrl + '/tour/calendar/copyweek', {year: y, month: m, day: d, tour_id: tour_id, json: JSON.stringify(week)},
            function (data) {
                full_array_tours = JSON.parse(data);
                $('#datepicker-tour').datepicker('update');
                //Очищаем чекбоксы
                for (let i = 1; i <= 7; i++) {
                    $('#data-week-' + i).prop('checked', false);
                }
            });
    });

});



