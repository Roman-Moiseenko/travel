$(document).ready(function () {
    var tour_id = $('#number-tour').val(); //Текущий тур
    var full_array_tours; //Массив туров по дням
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
            startDate: '+1d',
            language: "ru",
            autoclose: true,
        });
    });
    $('#datepicker-tour').datepicker({
        startDate: '+1d',
        language: 'ru',

        beforeShowDay: function (date) {
            if (full_array_tours === undefined) return {enabled: false};
            var tours = full_array_tours[date.getFullYear()]; //Массив по текущему году
            if (tours === undefined) return {enabled: false};
            tours = tours[date.getMonth() + 1];
            if (tours === undefined) return {enabled: false}; //Массив по текущему месяцу
            tours = tours[date.getDate()];
            if (tours === undefined) return {enabled: false}; //Объект по текущему дню
          //  var dateSel = $("#datepicker-tour").datepicker("getDate"); //Выбранная ячейка
          //  var content = date.getDate() + '<div style="font-size: small;">' + tours.count + ' туров' + '</div>';
          /*  if (dateSel !== null && dateSel.getDate() === date.getDate()) { //Совпала с текущим днем
                return {enabled: true, classes: 'tour-day-select', tooltip: '', content: content};
            }*/
            return {enabled: true, classes: 'tour-day'};
        }
    });
    //Событие при выборе даты
   $('#datepicker-tour').datepicker().on('changeDate', function (e) {
        console.log(e);
            // получаем сведения о тек.дне
            $.post('/tours/booking/getday',
                {year: e.date.getFullYear(), month: e.date.getMonth() + 1, day: e.date.getDate(), tour_id: tour_id},
                function (data) {
                    console.log(data);
                    $('.list-tours').html(data);
                });
    });

    //Событие при выборе месяца
    $('#datepicker-tour').datepicker().on('changeMonth', function (e) {

        $.post('/tours/booking/getcalendar',
            {tour_id: tour_id, month: e.date.getMonth() + 1, year: e.date.getFullYear()}, function (data) {
                console.log(data);
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
                console.log(tours);
                for (var i = 1; i <= 31; i ++) {
                    if (tours[i] !== undefined) {
                        $('#datepicker-tour').datepicker('update', new Date(e.date.getFullYear() + '/' + (e.date.getMonth() + 1) + '/' + i));
                        $.post('/tours/booking/getday',
                            {year: e.date.getFullYear(), month: e.date.getMonth() + 1, day: i, tour_id: tour_id},
                            function (data) {
                                $('.list-tours').html(data);
                            });
                        return true;
                    }
                }
              //  $('#datepicker-tour').datepicker('setDate', new Date(e.date.getFullYear() + '/' + (e.date.getMonth() + 1) + '/01'));
                //Находим первое число в тек. месяце, если нет, то не обновляем

               // $('#datepicker-tour').datepicker('clearDates');
            /*
            $.post('/tours/booking/getday',
                    {year: e.date.getFullYear(), month: e.date.getMonth() + 1, day: 1, tour_id: tour_id},
                    function (data) {
                        $('.list-tours').html(data);
                    });
*/
            });
    });

    //Загружаем Массив туров по дням за текущий день
    $.post('/tours/booking/getcalendar', {tour_id: tour_id, current_month: true}, function (data) {
        console.log(data);
        full_array_tours = JSON.parse(data);
        $('#datepicker-tour').datepicker('update');
    });


});



