$(document).ready(function () {
    let fun_id = $('#number-fun').val(); //Текущее авто
    let _date = null;
    let full_array_funs; //Массив туров по дням
    //let full_array_cars_to; //Массив туров по дням
    if ($.fn.datepicker === undefined) return false;
    let lang = $("#datepicker-fun").data('lang');

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
        $("#datepicker-fun").datepicker({
            format: 'dd/mm/yyyy',
            startDate: '+1d',
            language: lang,
            autoclose: true,
        });
    });

    $('#datepicker-fun').datepicker({
        startDate: '+1d',
        language: lang,
        beforeShowDay: function (date) {
            if (full_array_funs === undefined) return {enabled: false};
            var cars = full_array_funs[date.getFullYear()]; //Массив по текущему году
            if (cars === undefined) return {enabled: false};
            cars = cars[date.getMonth() + 1];
            if (cars === undefined) return {enabled: false}; //Массив по текущему месяцу
            cars = cars[date.getDate()];
            if (cars === undefined) return {enabled: false}; //Объект по текущему дню
            return {enabled: true};
        }
    });

    //Событие при выборе даты
    $('#datepicker-fun').datepicker().on('changeDate', function (e) {
        $.post('/funs/booking/get-times',
            {year: e.date.getFullYear(), month: e.date.getMonth() + 1, day: e.date.getDate(), fun_id: fun_id},
            function (data) {
                //console.log(data);
                $('.list-times').html(data);
                $('#button-booking-fun').attr('disabled', 'disabled');
            });
        $('#datepicker-fun').datepicker('hide');

    });

    //Загружаем Календарь от текущей даты
    if (document.getElementById('datepicker-fun')) {
        $.post('/funs/booking/get-calendar', {fun_id: fun_id}, function (data) {
            //console.log(data);
            full_array_funs = JSON.parse(data);
            //console.log('Грузим календарь');
            $('#datepicker-fun').datepicker('update');
        });
    }

    //Выбираем время
    $(document).on('change', '#booking-fun-times', function () {
        let calendar_id = $(this).val();
        // console.log(calendar_id);
        if (calendar_id !== -1) {
            $.post('/funs/booking/get-tickets', {calendar_id: calendar_id}, function (data) {
                //console.log(data);
                $('.tickets-funs').html(data);
                $('#button-booking-fun').attr('disabled', 'disabled');
            });
        } else {
            $('.tickets-funs').html('');
            $('#button-booking-fun').attr('disabled', 'disabled');
        }
    });

    //Изменяем кол-во билетов
    $(document).on('input', '.count-tickets-fun', function (data) {
        let _count_ = $(this).val();
        let vl = _count_.replace(/[^\d+]/g, ''); //str.replace(/[^a-zA-Z ]/g, "")
        if (vl === '') {vl = 0;}
        if (Number(vl) > 999) vl = 999;
        $(this).val(vl);
        $(this).change();

        let calendar_id = $('#calendar-id').val();
        let count_tickets = Number($('#label-count-tickets').attr('data-count'));
        let count_adult = $('#count-adult').val();
        if (count_adult === undefined) count_adult = 0;
        let count_child = $('#count-child').val();
        if (count_child === undefined) count_child = 0;
        let count_preference = $('#count-preference').val();
        if (count_preference === undefined) count_preference = 0;

        if (count_tickets < (Number(count_adult) + Number(count_child) + Number(count_preference))) {
            $('#button-booking-fun').attr('disabled', 'disabled');
            $('.errors-funs').html('Превышено кол-во билетов');
        } else {
            $('.errors-funs').html('');
            if (Number(count_adult) + Number(count_child) + Number(count_preference) > 0) {
                $('#button-booking-fun').removeAttr('disabled');
            } else {
                $('#button-booking-fun').attr('disabled', 'disabled');
                $('.errors-funs').html('Не указано кол-во билетов');
            }
        }
        if (calendar_id !== -1) {
            //console.log(calendar_id);
            $.post('/funs/booking/get-amount', {
                calendar_id: calendar_id,
                count_adult: count_adult,
                count_child: count_child,
                count_preference: count_preference
            }, function (data) {
                $('#fun-amount').html(data);
                //$('#show_comment').hide();
            });
        }
    });

    //Отправка данных на покупку
    $(document).on('click', '#button-booking-fun', function () {
        let car_id = $('#number-car').val();
        //let date_from = $(this).val();
        //let date_to = $(this).val();
        let count_car = $('#count-car').val();
        let delivery = $('#delivery').prop('checked');
        let comment = $('#comment').val();
        let promo = $('#discount').val();
        //console.log(car_id);
            $.post('/cars/checkout/booking',
                {car_id: car_id, date_from: date_from, date_to: date_to, count_car: count_car,
                    delivery: delivery, comment: comment, promo: promo}, function (data) {
                $('#rent-car').html(data);
            });
    });

    function set_amount_html(count_car) {
        $.post('/cars/booking/get-amount', {car_id: car_id, date_from: date_from, date_to: date_to, count_car: count_car}, function (data) {
            $('#rent-car-amount').html(data);
        });
    }
});



