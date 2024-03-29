$(document).ready(function () {
    let tour_id = $('#number-tour').val(); //Текущий тур
    let full_array_tours; //Массив туров по дням
    if ($.fn.datepicker === undefined) return false;
    let lang = $("#datepicker-tour").data('lang');
    let _private = $('#number-tour').data('private'); //Тур индивидуальный
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
        format: "dd/mm/yyyy",
        weekHeader: "Нед",
        titleFormat: "MM yyyy",
        weekStart: 1
    };
    //Устанавливаем datepicker
    $(function () {
        $("#datepicker-tour").datepicker({
            format: 'dd/mm/yyyy',
            startDate: 'd',
            language: lang,
            autoclose: true,
        });
    });
    $('#datepicker-tour').datepicker({
        startDate: 'd',
        language: lang,
        beforeShowDay: function (date) {
            if (full_array_tours === undefined) return {enabled: false};
            var tours = full_array_tours[date.getFullYear()]; //Массив по текущему году
            if (tours === undefined) return {enabled: false};
            tours = tours[date.getMonth() + 1];
            if (tours === undefined) return {enabled: false}; //Массив по текущему месяцу
            tours = tours[date.getDate()];
            if (tours === undefined) return {enabled: false}; //Объект по текущему дню
            return {enabled: true};
        }
    });
    //Событие при выборе даты
    $('#datepicker-tour').datepicker().on('changeDate', function (e) {
        //console.log(e);
        // получаем сведения о тек.дне
        $.post('/tours/booking/getlisttours',
            {year: e.date.getFullYear(), month: e.date.getMonth() + 1, day: e.date.getDate(), tour_id: tour_id},
            function (data) {
                //console.log(data);
                $('.list-tours').html(data);
                $('#button-booking-tour').attr('disabled', 'disabled');
            });
        $('#datepicker-tour').datepicker('hide');
    });

    //Событие при выборе месяца
    $('#datepicker-tour').datepicker().on('changeMonth', function (e) {

        $.post('/tours/booking/getcalendar',
            {tour_id: tour_id, month: e.date.getMonth() + 1, year: e.date.getFullYear()}, function (data) {
                // console.log(data);
                full_array_tours = JSON.parse(data);
                if (full_array_tours === undefined) {
                    $('.list-tours').html();
                    return true;
                }
                var tours = full_array_tours[e.date.getFullYear()]; //Массив по текущему году
                if (tours === undefined) {
                    $('.list-tours').html();
                    return true;
                }
                tours = tours[e.date.getMonth() + 1];
                if (tours === undefined) {
                    $('.list-tours').html();
                    return true;
                } //Массив по текущему месяцу
                $('#button-booking-tour').attr('disabled', 'disabled');
                for (var i = 1; i <= 31; i++) {
                    if (tours[i] !== undefined) {
                        $('#datepicker-tour').datepicker('update', new Date(e.date.getFullYear() + '/' + (e.date.getMonth() + 1) + '/' + i));
                        $.post('/tours/booking/getlisttours',
                            {year: e.date.getFullYear(), month: e.date.getMonth() + 1, day: i, tour_id: tour_id},
                            function (data) {
                                $('.list-tours').html(data);
                            });
                        return true;
                    }
                }
            });
    });

    //Загружаем Массив туров по дням за текущий месяц
    if (document.getElementById('datepicker-tour')) {
        $.post('/tours/booking/getcalendar', {tour_id: tour_id, current_month: true}, function (data) {
            //console.log(data);
            full_array_tours = JSON.parse(data);
            $('#datepicker-tour').datepicker('update');
        });
    }

    $(document).on('change', '#booking-tour-time', function () {
        let calendar_id = $(this).val();
        // console.log(calendar_id);
        if (calendar_id != -1) {
            $.post('/tours/booking/gettickets', {calendar_id: calendar_id}, function (data) {
                //console.log(data);
                $('.tickets-tours').html(data);
                if (_private) {
                    $('#button-booking-tour').removeAttr('disabled');
                    $.post('/tours/booking/get-amount', {
                        calendar_id: calendar_id,
                        count_adult: 1,
                        count_child: 0,
                        count_preference: 0
                    }, function (data) {
                        $('#tour-amount').html(data);
                    });
                } else {
                    $('#button-booking-tour').attr('disabled', 'disabled');
                }
            });
        } else {
            $('.tickets-tours').html('');
            $('#button-booking-tour').attr('disabled', 'disabled');
        }
    });

    $(document).on('change', '.services', function () {
        let calendar_id = $('#booking-tour-time').val();
        let time_count = $('#time-count').val();
        let capacity_id = $('#capacity-id').val();
        let transfer_id = $('#transfer-id').val();
        console.log(time_count);
        console.log(capacity_id);
        console.log(transfer_id);

        $.post('/tours/booking/get-amount', {
            calendar_id: calendar_id,
            count_adult: 1,
            count_child: 0,
            count_preference: 0,
            time_count: time_count,
            capacity_id: capacity_id,
            transfer_id: transfer_id
        }, function (data) {
            console.log('3333333');
            console.log(data);

            $('#tour-amount').html(data);
        });
    });

    $(document).on('input', '.count-tickets', function (data) {
        let _count_ = $(this).val();
        let vl = _count_.replace(/[^\d+]/g, ''); //str.replace(/[^a-zA-Z ]/g, "")
        if (vl == '') {vl = 0;}
        if (Number(vl) > 999) vl = 999;
        $(this).val(vl);
        $(this).change();

        let calendar_id = $('#booking-tour-time').val();
        let count_tickets = Number($('#label-count-tickets').attr('data-count'));

        let count_adult = $('#count-adult').val();
        if (count_adult === undefined) count_adult = 0;
        let count_child = $('#count-child').val();
        if (count_child === undefined) count_child = 0;
        let count_preference = $('#count-preference').val();
        if (count_preference === undefined) count_preference = 0;

        if (count_tickets < (Number(count_adult) + Number(count_child) + Number(count_preference))) {
            $('#button-booking-tour').attr('disabled', 'disabled');
            $('.errors-tours').html('Превышено кол-во билетов');
        } else {
            $('.errors-tours').html('');
            if (Number(count_adult) + Number(count_child) + Number(count_preference) > 0) {
                $('#button-booking-tour').removeAttr('disabled');
            } else {
                $('#button-booking-tour').attr('disabled', 'disabled');
                $('.errors-tours').html('Не указано кол-во билетов');
            }
        }
        if (calendar_id !== -1) {
            $.post('/tours/booking/get-amount', {
                calendar_id: calendar_id,
                count_adult: count_adult,
                count_child: count_child,
                count_preference: count_preference
            }, function (data) {
                $('#tour-amount').html(data);
            });
        }
    });
});



