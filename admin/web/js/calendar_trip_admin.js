$(document).ready(function () {
    /** ver 16.11.2020 */
    let trip_id = $('#number-trip').val(); //Текущий тур
    let full_array_trips; //Массив туров по дням

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
        $("#datepicker-trip").datepicker({
            format: "dd/mm/yyyy",
            startDate: '+1d',
            language: "ru",
        });
    });
    $('#datepicker-trip').datepicker({
        startDate: '+1d',
        format: 'dd/mm/yyyy',
        language: 'ru',
        beforeShowDay: function (date) {
            let dateSel = $("#datepicker-trip").datepicker("getDate"); //Выбранная ячейка
            if (full_array_trips === undefined) return {enabled: true};
            let trips = full_array_trips[date.getFullYear()]; //Массив по текущему году
            if (trips === undefined) return {enabled: true};
            trips = trips[date.getMonth() + 1];
            if (trips === undefined) return {enabled: true}; //Массив по текущему месяцу
            trips = trips[date.getDate()];
            if (trips === undefined) return {enabled: true}; //Объект по текущему дню

            var content = date.getDate() + '<div style="font-size: small;">Старт тура </div>' +
                '<div style="font-size: small;">' + trips.quantity + ' мест' + '</div>';
            if (dateSel !== null && dateSel.getDate() === date.getDate() && date.getMonth() === dateSel.getMonth()) { //Совпала с текущим днем
                return {enabled: true, classes: 'calendar-day-select', tooltip: '', content: content};
            }
            return {enabled: true, classes: 'calendar-day', tooltip: '', content: content};
        }
    });
    //Событие при выборе даты
    $('#datepicker-trip').datepicker().on('changeDate', function (e) {
        //получаем сведения о тек.дне
        if (e.date === undefined) return;
        $.post('/trip/calendar/getday',
            {year: e.date.getFullYear(), month: e.date.getMonth() + 1, day: e.date.getDate(), trip_id: trip_id},
            function (data) {
           // console.log(data);
                let dateInfo = JSON.parse(data);
                $('.list-trips').html(dateInfo._list);
                $('.copy-week-times').html(dateInfo.copy_week_times);
                $('.new-trip').html(dateInfo.new_trip);
                $('#datepicker-trip').datepicker('hide');
            });
    });

    //Загружаем Массив туров по дням за текущий день
    if (document.getElementById('datepicker-trip')) {
        $.post('/trip/calendar/getcalendar', {trip_id: trip_id, current_month: true}, function (data) {
            full_array_trips = JSON.parse(data);
            $('#datepicker-trip').datepicker('update');
        });
    }

    $(document).on('click', '#send-new-trip', function () {
        var d = $('#data-day').attr('data-d');
        var m = $('#data-day').attr('data-m');
        var y = $('#data-day').attr('data-y');

        var quantity= $('#quantity').val();
        var cost_base = $('#cost_base').val();

        let params = new Array();
        let cost_list = new Array();
        $('.cost-params').each(function(i){
            params.push({params: $(this).data('params'), cost: $(this).val()});
        });
        $('.cost-list').each(function(i){
            cost_list.push({class: $(this).data('class'), id: $(this).data('id'), cost: $(this).val()});
        });

        //console.log(params);
        //console.log(cost_list);
        $.post('/trip/calendar/setday',
            {
                year: y, month: m, day: d, trip_id: trip_id,
                quantity: quantity, cost_base: cost_base, params: params, cost_list: cost_list
            },
            function (data) {
                //console.log(data);
                var dateInfo = JSON.parse(data);
                $('.list-trips').html(dateInfo._list);
                $('.new-trip').html(dateInfo.new_trip);
                full_array_trips = dateInfo.full_array_trips;
                $('#datepicker-trip').datepicker('update'); //, new Date(y + '/' + m + '/' + d)
                $('.copy-week-times').html(dateInfo.copy_week_times);
            });

    });

    $(document).on('click', '.del-day', function () {
        let d = $('#data-day').attr('data-d');
        let m = $('#data-day').attr('data-m');
        let y = $('#data-day').attr('data-y');
        let calendar_id = $(this).attr('data-id');
        $.post('/trip/calendar/delday',
            {
                year: y, month: m, day: d, trip_id: trip_id,
                calendar_id: calendar_id
            },
            function (data) {
                let dateInfo = JSON.parse(data);
                $('.list-trips').html(dateInfo._list);
                $('.new-trip').html(dateInfo.new_trip);
                full_array_trips = dateInfo.full_array_trips;
                $('#datepicker-trip').datepicker('update'); //, new Date(y + '/' + m + '/' + d)
            });
    });

    $(document).on('click', '#trip-data-week-copy', function () {
        let d = $('#data-day').attr('data-d');
        let m = $('#data-day').attr('data-m');
        let y = $('#data-day').attr('data-y');
        let week = [];
        week[0] = $('#end-day').val();
        for (let i = 1; i <= 7; i++) {
            week[i] = $('#data-week-' + i).is(':checked');
        }
        $.post('/trip/calendar/copyweek', {year: y, month: m, day: d, trip_id: trip_id, json: JSON.stringify(week)},
            function (data) {
                //console.log(data);
                full_array_trips = JSON.parse(data);
                $('#datepicker-trip').datepicker('update');
                //Очищаем чекбоксы
                for (let i = 1; i <= 7; i++) {
                    $('#data-week-' + i).prop('checked', false);
                }
            });
    });

    $(document).on('change', '#data-week-0', function () {
            for (let i = 1; i <= 7; i++) {
                $('#data-week-' + i).prop('checked', $('#data-week-0').is(':checked'));
        }
    });

});



