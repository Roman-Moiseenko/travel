$(document).ready(function () {
    let stay_id = $('#number-stay').val(); //Текущий тур
    let full_array_stays; //Массив туров по дням

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
        format: "dd/mm/yyyy",
        weekHeader: "Нед",
        titleFormat: "MM yyyy",
        weekStart: 1
    };
    //Устанавливаем datepicker
    $(function () {
        $("#datepicker-stay").datepicker({
            format: "dd/mm/yyyy",
            startDate: '+1d',
            language: "ru",
        });
    });
    $('#datepicker-stay').datepicker({
        startDate: '+1d',
        language: 'ru',
        beforeShowDay: function (date) {
            let dateSel = $("#datepicker-stay").datepicker("getDate"); //Выбранная ячейка
            if (full_array_stays === undefined) return {enabled: true};
            var stays = full_array_stays[date.getFullYear()]; //Массив по текущему году
            if (stays === undefined) return {enabled: true};
            stays = stays[date.getMonth() + 1];
            if (stays === undefined) return {enabled: true}; //Массив по текущему месяцу
            stays = stays[date.getDate()];
            if (stays === undefined) return {enabled: true}; //Объект по текущему дню
            let _add = '';
            if (stays.cost_add !== undefined && stays.cost_add !== 0) {
                _add = '<div style="font-size: small;">(+' + stays.cost_add + ' руб' + ')</div>';
            }
            let content = date.getDate() + '<div style="font-size: small;">' + stays.cost_base + ' руб' + '</div>' + _add;
            if (dateSel !== null && dateSel.getDate() === date.getDate() && date.getMonth() === dateSel.getMonth()) { //Совпала с текущим днем
                return {enabled: true, classes: 'calendar-day-select', tooltip: '', content: content};
            }
            return {enabled: true, classes: 'calendar-day', tooltip: '', content: content};
        }
    });
    //Событие при выборе даты
    $('#datepicker-stay').datepicker().on('changeDate', function (e) {
        if (e.date === undefined) return;
        $.post('/stay/calendar/getday',
            {year: e.date.getFullYear(), month: e.date.getMonth() + 1, day: e.date.getDate(), stay_id: stay_id},
            function (data) {
                //console.log(data);
                let dateInfo = JSON.parse(data);
                $('.list-stays').html(dateInfo._list);
                $('#datepicker-stay').datepicker('hide');
                $('.copy-week-times').html(dateInfo.copy_week_times);
            });
        // }
    });

    //Загружаем Массив туров по дням за текущий день
    if (document.getElementById('datepicker-stay')) {
        $.post('/stay/calendar/getcalendar', {stay_id: stay_id}, function (data) {
            //console.log(data);
            full_array_stays = JSON.parse(data);
            $('#datepicker-stay').datepicker('update');
        });
    }

    $(document).on('click', '#send-new-stay', function () {
        let d = $('#data-day').attr('data-d');
        let m = $('#data-day').attr('data-m');
        let y = $('#data-day').attr('data-y');
        let cost_base = $('#cost-base').val();
        let guest_base = $('#guest-base').val();
        let cost_add = $('#cost-add').val();
        $.post('/stay/calendar/setday',
            {
                year: y, month: m, day: d, stay_id: stay_id,
                cost_base: cost_base, guest_base: guest_base, cost_add: cost_add
            },
            function (data) {
                //console.log(data);
                var dateInfo = JSON.parse(data);
                $('.list-stays').html(dateInfo._list);
                full_array_stays = dateInfo.full_array_stays;
                $('#datepicker-stay').datepicker('update'); //, new Date(y + '/' + m + '/' + d)
                $('.copy-week-times').html(dateInfo.copy_week_times);
            });
    });

    $(document).on('click', '#stay-del-day', function () {
        let d = $('#data-day').attr('data-d');
        let m = $('#data-day').attr('data-m');
        let y = $('#data-day').attr('data-y');
        let calendar_id = $(this).attr('data-id');
        console.log(calendar_id);
        console.log(y);
        console.log(m);
        console.log(d);
        console.log(stay_id);
        $.post('/stay/calendar/delday',
            {
                year: y, month: m, day: d, stay_id: stay_id,
                calendar_id: calendar_id
            },
            function (data) {
                //console.log(data);
                let dateInfo = JSON.parse(data);
                $('.list-stays').html(dateInfo._list);
               // $('.new-stays').html(dateInfo._new);
                full_array_stays = dateInfo.full_array_stays;
                $('#datepicker-stay').datepicker('update');
                $('.copy-week-times').html(dateInfo.copy_week_times);
            });
    });

    $(document).on('click', '#stay-data-week-copy', function () {
        let d = $('#data-day').attr('data-d');
        let m = $('#data-day').attr('data-m');
        let y = $('#data-day').attr('data-y');
        let week = [];
        week[0] = $('#end-day').val();
        for (let i = 1; i <= 7; i++) {
            week[i] = $('#data-week-' + i).is(':checked');
        }
        $.post('/stay/calendar/copyweek', {
                year: y,
                month: m,
                day: d,
                stay_id: stay_id,
                json: JSON.stringify(week)
            },
            function (data) {
                console.log(data);
                full_array_stays = JSON.parse(data);
                $('#datepicker-stay').datepicker('update');
                //Очищаем чекбоксы
                for (let i = 1; i <= 7; i++) {
                    $('#data-week-' + i).prop('checked', false);
                }
            });
    });
});



