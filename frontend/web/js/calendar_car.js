$(document).ready(function () {
    let car_id = $('#number-car').val(); //Текущее авто
    let date_from = null;
    let date_to = null;
    let full_array_cars_from; //Массив туров по дням
    let full_array_cars_to; //Массив туров по дням
    if ($.fn.datepicker === undefined) return false;
    let lang = $("#datepicker-car-from").data('lang');

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
        $("#datepicker-car").datepicker({
            format: 'dd/mm/yyyy',
            startDate: '+1d',
            language: lang,
            autoclose: true,
        });
        $("#datepicker-car-to").datepicker({
            format: 'dd/mm/yyyy',
            startDate: '+1d',
            language: lang,
            autoclose: true,
        });
    });

    $('#datepicker-car-from').datepicker({
        startDate: '+1d',
        language: lang,
        beforeShowDay: function (date) {
            if (full_array_cars_from === undefined) return {enabled: false};
            var cars = full_array_cars_from[date.getFullYear()]; //Массив по текущему году
            if (cars === undefined) return {enabled: false};
            cars = cars[date.getMonth() + 1];
            if (cars === undefined) return {enabled: false}; //Массив по текущему месяцу
            cars = cars[date.getDate()];
            if (cars === undefined) return {enabled: false}; //Объект по текущему дню
            return {enabled: true};
        }
    });

    $('#datepicker-car-to').datepicker({
        startDate: '+1d',
        language: lang,
        beforeShowDay: function (date) {
            if (full_array_cars_to === undefined) return {enabled: false};
            var cars = full_array_cars_to[date.getFullYear()]; //Массив по текущему году
            if (cars === undefined) return {enabled: false};
            cars = cars[date.getMonth() + 1];
            if (cars === undefined) return {enabled: false}; //Массив по текущему месяцу
            cars = cars[date.getDate()];
            if (cars === undefined) return {enabled: false}; //Объект по текущему дню
            return {enabled: true};
        }
    });
    //Событие при выборе даты
    $('#datepicker-car-from').datepicker().on('changeDate', function (e) {
        date_from = e.date.getDate() + '-' + (e.date.getMonth() + 1) + '-' + e.date.getFullYear();
        $.post('/cars/booking/get-calendar', {car_id: car_id, date_from: date_from}, function (data) {
            // обновляем второй календарь
            //console.log(data);
            full_array_cars_to = JSON.parse(data);
            $('#datepicker-car-to').datepicker('update');
            //Еслы выбраны обе даты, грузим данные для покупки
            if (date_to != null) {
                $.post('/cars/booking/get-rent-car',
                    {car_id: car_id, date_from: date_from, date_to: date_to},
                    function (data) {
                        $('#rent-car').html(data);
                        set_amount_html(1);
                        //Проверка на минимальное бронирование
                        if (document.getElementById("errors")) {
                            $('#button-booking-car').attr('disabled', 'disabled');
                        } else {
                            $('#button-booking-car').removeAttr('disabled');
                        }
                    });
            }
        });
        $('#datepicker-car-from').datepicker('hide');
    });

    $('#datepicker-car-to').datepicker().on('changeDate', function (e) {
        date_to = e.date.getDate() + '-' + (e.date.getMonth() + 1) + '-' + e.date.getFullYear();
        // получаем сведения о тек.дне
        $.post('/cars/booking/get-calendar', {car_id: car_id, date_to: date_to}, function (data) {
            // обновляем второй календарь
            full_array_cars_from = JSON.parse(data);
            $('#datepicker-car-from').datepicker('update');
            //Еслы выбраны обе даты, грузим данные для покупки
            if (date_from != null) {
                $.post('/cars/booking/get-rent-car',
                    {car_id: car_id, date_from: date_from, date_to: date_to},
                    function (data) {
                        $('#rent-car').html(data);
                        set_amount_html(1);
                        //Проверка на минимальное бронирование
                        if (document.getElementById("errors")) {
                            $('#button-booking-car').attr('disabled', 'disabled');
                        } else {
                            $('#button-booking-car').removeAttr('disabled');
                        }
                    });
            }
        });
        $('#datepicker-car-to').datepicker('hide');
    });

    //Загружаем Календарь по авто от текущей даты
    if (document.getElementById('datepicker-car-from')) {
        $.post('/cars/booking/get-calendar', {car_id: car_id}, function (data) {
            //console.log(data);
            full_array_cars_from = JSON.parse(data);
            full_array_cars_to = full_array_cars_from;
            //console.log('Грузим календарь');
            $('#datepicker-car-from').datepicker('update');
            $('#datepicker-car-to').datepicker('update');
        });
    }

    //Очистка календаря
    $(document).on('click', '#clear-car-calendar', function () {
        $.post('/cars/booking/get-calendar', {car_id: car_id}, function (data) {
            //console.log(data);
            full_array_cars_from = JSON.parse(data);
            full_array_cars_to = full_array_cars_from;
           // console.log('Грузим календарь');
            $('#datepicker-car-from').datepicker('update', '');
            $('#datepicker-car-to').datepicker('update', '');
            $('#rent-car').html('');
            date_from = null;
            date_to = null;
            $('#button-booking-car').attr('disabled', 'disabled');
        });
    });

    $(document).on('input', '#count-car', function (data) {
        let count_car = $('#count-car').val();
        let vl = count_car.replace(/[^\d+]/g, ''); //str.replace(/[^a-zA-Z ]/g, "")
        if (vl == '') {vl = 1; count_car = 1;}
        $(this).val(vl);
        $(this).change();
        //let amount = $('#rent-car-amount').data('amount');

        if (Number(count_car) > Number($('#count-car').attr('max'))){
            count_car = $('#count-car').attr('max');
            $(this).val(count_car);
            $(this).change();
        };
        $.post('/cars/booking/get-amount', {car_id: car_id, date_from: date_from, date_to: date_to, count_car: count_car}, function (data) {
            $('#rent-car-amount').html(data);
        });
    });

    $(document).on('click', '#delivery', function (data) {
      if ($(this).prop('checked')) {
          $('#show_comment').show();
      } else {
          $('#show_comment').hide();
      }
    });

    //Отправка данных на покупку
    $(document).on('click', '#button-booking-car', function () {
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



