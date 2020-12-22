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
                if_update_multi();
            });
        $('#datepicker-fun').datepicker('hide');

    });

    //Загружаем Календарь от текущей даты
    if (document.getElementById('datepicker-fun')) {
        $.post('/funs/booking/get-calendar', {fun_id: fun_id}, function (data) {
            full_array_funs = JSON.parse(data);
            $('#datepicker-fun').datepicker('update');
        });
    }

    //Выбираем время для не множественного типа
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
       /* let car_id = $('#number-car').val();
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
            });*/
    });


    //Выбираем время для множественного типа
    function if_update_multi() {
        if (document.getElementById("multi-timer")) {
            let _temp = $("#multi-timer").data('calendar');
            //получаем данные
            let calendars = JSON.parse(_temp.replaceAll("'", '"'));
            let _clicks = 0;
            let _first = -1;
            let _end = -1;
            update_multi();
            //нажата ячейка
            $(document).on("click", ".td-time", function () {
                _clicks++;
                if (_clicks === 1) {_first = $(this).data('number');} //1-й раз, старт
                if (_clicks === 2) {   //2-й раз, энд
                    _end = $(this).data('number');
                    if (_first > _end) {let a = _first; _first = _end; _end = a;} //меняем местами
                }
                if (_clicks > 2) { //последующие нажатия
                    let a = $(this).data('number');
                    if (a === _first || a === _end) { //совпало начало и конец
                        _first = a;
                        _end = a;
                    }
                    if (a < _first) _first = a;
                    if (a > _end) _end = a;
                    if (_first < a && a < _end) {
                        if (a < (_first + _end) / 2) {_first = a;} else {_end = a;}
                    }
                }
                update_multi();
                console.log(_clicks);
                if (_clicks > 1) get_tickets();
            });
            //рисуем таблицу
            function update_multi() {
                let _t = "";
                _t = "<table class=\"multi-timer\">";
                _t += "<tr>";
                let _count = calendars.length;
                let _class = '';
                for (let _i = 0; _i < _count; _i ++) {
                    _class = '';
                    if (_i === _first) _class = 'first';
                    if (_i === _end) _class = 'end';
                    if (_first < _i && _i < _end) _class ='between';
                    if (_i === _first && _first === _end) _class = 'firstend';
                    if (calendars[_i].count == 0) _class ='disable';
                    _t += '<td class="td-time ' + _class + '" data-number="'+ _i +'" data-id="' + calendars[_i].id + '">' +
                        calendars[_i].time +'<div><i class="fas fa-ticket-alt"></i> ' + calendars[_i].count + '</div>'+
                        '</td>';
                    if ((_i + 1) % 5 === 0) {_t += '</tr><tr>'};
                }
                _t += "</tr>";
                _t += "</table>";
                $("#multi-timer").html(_t);
            }
            //отправляем данные для получения полей ввода билетов
            function get_tickets() {
                console.log(calendars);
                $.post('/funs/booking/get-tickets', {calendar_id: calendars[_first].id}, function (data) {
                    //console.log(data);
                    $('.tickets-funs').html(data);
                    $('#button-booking-fun').attr('disabled', 'disabled');
                });
            }
        };
    }
});



