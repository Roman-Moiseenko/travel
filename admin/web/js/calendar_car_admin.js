$(document).ready(function () {
    let car_id = $('#number-car').val(); //Текущий тур
    let full_array_cars; //Массив туров по дням

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
        $("#datepicker-car").datepicker({
            format: "dd/mm/yyyy",
            startDate: '+1d',
            language: "ru",
        });
    });
    $('#datepicker-car').datepicker({
        startDate: '+1d',
        language: 'ru',
        beforeShowDay: function (date) {
            let dateSel = $("#datepicker-car").datepicker("getDate"); //Выбранная ячейка
            if (full_array_cars === undefined) return {enabled: true};
            var cars = full_array_cars[date.getFullYear()]; //Массив по текущему году
            if (cars === undefined) return {enabled: true};
            cars = cars[date.getMonth() + 1];
            if (cars === undefined) return {enabled: true}; //Массив по текущему месяцу
            cars = cars[date.getDate()];
            if (cars === undefined) return {enabled: true}; //Объект по текущему дню
            let content = date.getDate() + '<div style="font-size: small;">' + cars.count + ' авто' + '</div>' + '<div style="font-size: small;">' + cars.cost + ' руб' + '</div>';
            if (dateSel !== null && dateSel.getDate() === date.getDate() && date.getMonth() === dateSel.getMonth()) { //Совпала с текущим днем
                return {enabled: true, classes: 'calendar-day-select', tooltip: '', content: content};
            }
            return {enabled: true, classes: 'calendar-day', tooltip: '', content: content};
        }
    });
    //Событие при выборе даты
    $('#datepicker-car').datepicker().on('changeDate', function (e) {
        if (e.date === undefined) return;
        $.post('/car/calendar/getday',
            {year: e.date.getFullYear(), month: e.date.getMonth() + 1, day: e.date.getDate(), car_id: car_id},
            function (data) {
                let dateInfo = JSON.parse(data);
                $('.list-cars').html(dateInfo._list);
                $('#datepicker-car').datepicker('hide');
                $('.copy-week-times').html(dateInfo.copy_week_times);
            });
        // }
    });

    //Загружаем Массив туров по дням за текущий день
    if (document.getElementById('datepicker-car')) {
        $.post('/car/calendar/getcalendar', {car_id: car_id, current_month: true}, function (data) {
            full_array_cars = JSON.parse(data);
            $('#datepicker-car').datepicker('update');
        });
    }

    $(document).on('click', '#send-new-car', function () {
        let d = $('#data-day').attr('data-d');
        let m = $('#data-day').attr('data-m');
        let y = $('#data-day').attr('data-y');
        let _count = $('#_count').val();
        let _cost = $('#_cost').val();
        $.post('/car/calendar/setday',
            {
                year: y, month: m, day: d, car_id: car_id,
                _count: _count, _cost: _cost
            },
            function (data) {
                var dateInfo = JSON.parse(data);
                $('.list-cars').html(dateInfo._list);
                //$('.new-cars').html(dateInfo._new);
                full_array_cars = dateInfo.full_array_cars;
                $('#datepicker-car').datepicker('update'); //, new Date(y + '/' + m + '/' + d)
                $('.copy-week-times').html(dateInfo.copy_week_times);
            });
    });

    $(document).on('click', '#car-del-day', function () {
        let d = $('#data-day').attr('data-d');
        let m = $('#data-day').attr('data-m');
        let y = $('#data-day').attr('data-y');
        let calendar_id = $(this).attr('data-id');
        console.log(calendar_id);
        console.log(y);
        console.log(m);
        console.log(d);
        console.log(car_id);
        $.post('/car/calendar/delday',
            {
                year: y, month: m, day: d, car_id: car_id,
                calendar_id: calendar_id
            },
            function (data) {
                console.log(data);

                let dateInfo = JSON.parse(data);
                $('.list-cars').html(dateInfo._list);
                $('.new-cars').html(dateInfo._new);
                full_array_cars = dateInfo.full_array_cars;
                $('#datepicker-car').datepicker('update');
                $('.copy-week-times').html(dateInfo.copy_week_times);
            });
    });

    $(document).on('click', '#car-data-day-copy', function () {
        if ($('#data-day-copy').is(':checked')) {
            $('.new-cars').addClass('hidden');
            $('#data-week-copy').prop("disabled", true);
        } else {
            $('.new-cars').removeClass('hidden');
            $('#data-week-copy').prop("disabled", false);
        }
    });

    $(document).on('click', '#car-data-week-copy', function () {
        let d = $('#data-day').attr('data-d');
        let m = $('#data-day').attr('data-m');
        let y = $('#data-day').attr('data-y');
        let week = [];
        week[0] = $('#end-day').val();
        for (let i = 1; i <= 7; i++) {
            week[i] = $('#data-week-' + i).is(':checked');
        }
        $.post('/car/calendar/copyweek', {
                year: y,
                month: m,
                day: d,
                car_id: car_id,
                json: JSON.stringify(week)
            },
            function (data) {
                full_array_cars = JSON.parse(data);
                $('#datepicker-car').datepicker('update');
                //Очищаем чекбоксы
                for (let i = 1; i <= 7; i++) {
                    $('#data-week-' + i).prop('checked', false);
                }
            });
    });
});



