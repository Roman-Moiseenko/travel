$(document).ready(function () {
    /** ver 16.11.2020 */
    let fun_id = $('#number-fun').val(); //Текущее Развлечение
    let full_array_funs; //Массив по дням
    let baseUrl = '';
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
        $("#datepicker-fun").datepicker({
            format: "mm/dd/yyyy",
            startDate: "+1d",
            language: "ru",
        });
    });
    $("#datepicker-fun").datepicker({
        startDate: "+1d",
        language: "ru",
        beforeShowDay: function (date) {
            let dateSel = $("#datepicker-fun").datepicker("getDate"); //Выбранная ячейка
            if (dateSel !== null) current_month = dateSel.getMonth();
            if (full_array_funs === undefined) return {enabled: true};
            var funs = full_array_funs[date.getFullYear()]; //Массив по текущему году
            if (funs === undefined) return {enabled: true};
            funs = funs[date.getMonth() + 1];
            if (funs === undefined) return {enabled: true}; //Массив по текущему месяцу
            funs = funs[date.getDate()];
            if (funs === undefined) return {enabled: true}; //Объект по текущему дню
            var content = date.getDate() + '<div style="font-size: small;">' + funs.count + ' инт.' + '</div>' +
                '<div style="font-size: small;">' + funs.tickets + ' мест' + '</div>';
            if (dateSel !== null && dateSel.getDate() === date.getDate() && date.getMonth() === dateSel.getMonth()) { //Совпала с текущим днем
                return {enabled: true, classes: 'calendar-day-select', tooltip: '', content: content};
            }
            return {enabled: true, classes: 'calendar-day', tooltip: '', content: content};

        }
    });
    //Событие при выборе даты
    $('#datepicker-fun').datepicker().on('changeDate', function (e) {
        //Иначе получаем сведения о тек.дне
        if (e.date === undefined) return;
        if (e.date.getMonth() !== current_month) current_month = e.date.getMonth();
        updateDayInfo(e.date.getFullYear(), e.date.getMonth() + 1, e.date.getDate());
        $(".error-time").html('');
        $('#datepicker-fun').datepicker('hide');
    });

    //Событие при выборе месяца
    $('#datepicker-fun').datepicker().on('changeMonth', function (e) {
        current_month = e.date.getMonth();
    });


    //Загружаем Массив туров по дням за текущий день
    if (document.getElementById('datepicker-fun')) {
        updateArrayFuns()
    }

    //ОТПРАВИТЬ НА СОХРАНЕНИЕ
    $(document).on('click', '#send-new-fun', function () {
        let d = $('#data-day').attr('data-d');
        let m = $('#data-day').attr('data-m');
        let y = $('#data-day').attr('data-y');
        let count_times = $('#data-day').data('count-times');
        let array_new_times = [];

        for (let i = 0; i < count_times; i++) {
            //Заполняем массив данными
            if ($('#checkbox-' + i).is(':checked')) {
                array_new_times.push({
                    i: i,
                    begin: $('#begin-' + i).val(),
                    end: $('#end-' + i).val(),
                    quantity: $('#quantity-' + i).val(),
                    cost_adult: $('#cost-adult-' + i).val(),
                    cost_child: $('#cost-child-' + i).val(),
                    cost_preference: $('#cost-preference-' + i).val(),
                });
            }
        }
        if (count_times === 0) {
            array_new_times.push({
                i: -1,
                begin: null,
                end: null,
                quantity: $('#quantity').val(),
                cost_adult: $('#cost-adult').val(),
                cost_child: $('#cost-child').val(),
                cost_preference: $('#cost-preference').val(),
            });
        }
        $.post(baseUrl + '/fun/calendar/setday',
            {
                year: y, month: m, day: d, fun_id: fun_id,
                times: array_new_times
            },
            function (data) {
                $(".error-time").html(data);
                updateDayInfo(y, m, d);
                updateArrayFuns();
            });
    });
    //Очищаем текущий день
    $(document).on('click', '#send-del-fun', function () {
        var d = $("#data-day").attr('data-d');
        var m = $("#data-day").attr('data-m');
        var y = $("#data-day").attr('data-y');
        $.post(baseUrl + '/fun/calendar/delday',
            {year: y, month: m, day: d, fun_id: fun_id},
            function (data) {
                $(".error-time").html(data);
                updateArrayFuns();
                updateDayInfo(y, m, d);
            });
    });

    $(document).on('click', '#fun-data-week-copy', function () {
        var d = $('#data-day').attr('data-d');
        var m = $('#data-day').attr('data-m');
        var y = $('#data-day').attr('data-y');
        let week = [];
        week[0] = $('#end-day').val();
        for (let i = 1; i <= 7; i++) {
            week[i] = $('#data-week-' + i).is(':checked');
        }
        $.post(baseUrl + '/fun/calendar/copyweek', {
            year: y,
            month: m,
            day: d,
            fun_id: fun_id,
            json: JSON.stringify(week)
        },
            function (data) {
                $(".error-time").html(data);
                updateArrayFuns();
                //Очищаем чекбоксы
                for (let i = 1; i <= 7; i++) {
                    $('#data-week-' + i).prop('checked', false);
                }
            });
    });

    //ОБНОВИТЬ СВЕДЕНИЯ ЗА ДЕНЬ
    function updateDayInfo(y, m, d) {
        $.post(baseUrl + '/fun/calendar/getday',
            {year: y, month: m, day: d, fun_id: fun_id},
            function (data) {
                //console.log(data);
                let dateInfo = JSON.parse(data);
                //console.log(data);
                $('.set-times').html(dateInfo.set_times);
                $('.button-times').html(dateInfo.button_times);
                $('.copy-week-times').html(dateInfo.copy_week_times);
            });
    }

    //ЗАГРУЗИТЬ КАЛЕНДАРЬ
    function updateArrayFuns() {
        $.post(baseUrl + '/fun/calendar/getcalendar', {fun_id: fun_id, current_month: true}, function (data) {
            full_array_funs = JSON.parse(data);
            $('#datepicker-fun').datepicker('update');
        });
    }
});



